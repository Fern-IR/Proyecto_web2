<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Reserva;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PagoController extends Controller
{
    public function index(): View
    {
        $idOperador = Auth::user()->id_operador;

        $pagos = Pago::query()
            ->with(['reserva.cliente', 'reserva.disponibilidad.paquete'])
            ->whereHas('reserva.disponibilidad.paquete', fn ($q) => $q->where('id_operador', $idOperador))
            ->latest('id_pago')
            ->paginate(10);

        return view('pagos.index', compact('pagos'));
    }

    public function create(Request $request): View
    {
        $idOperador = Auth::user()->id_operador;

        $reservas = Reserva::query()
            ->with(['cliente', 'disponibilidad.paquete'])
            ->whereHas('disponibilidad.paquete', fn ($q) => $q->where('id_operador', $idOperador))
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->orderByDesc('id_reserva')
            ->get();

        return view('pagos.create', [
            'reservas' => $reservas,
            'selectedReserva' => $request->integer('reserva'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id_reserva' => ['required', 'exists:reservas,id_reserva'],
            'metodo_pago' => ['required', 'string', 'max:50'],
            'monto' => ['required', 'numeric', 'min:0'],
            'estado_pago' => ['required', 'in:pendiente,pagado,rechazado'],
            'comprobante' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        $reserva = Reserva::with('disponibilidad.paquete')->findOrFail($data['id_reserva']);
        $this->authorizeReserva($reserva);

        $pago = Pago::create([
            'id_reserva' => $reserva->id_reserva,
            'metodo_pago' => $data['metodo_pago'],
            'monto' => $data['monto'],
            'estado_pago' => $data['estado_pago'],
        ]);

        if ($request->hasFile('comprobante')) {
            $ruta = $request->file('comprobante')->store('comprobantes', 'public');
            $pago->comprobantes()->create([
                'ruta_archivo' => $ruta,
                'fecha_subida' => now(),
            ]);
        }

        return redirect()->route('pagos.index')->with('success', 'Pago registrado correctamente.');
    }

    public function edit(Pago $pago): View
    {
        $pago->load('reserva.disponibilidad.paquete');
        $this->authorizeReserva($pago->reserva);

        return view('pagos.edit', compact('pago'));
    }

    public function update(Request $request, Pago $pago): RedirectResponse
    {
        $pago->load('reserva.disponibilidad.paquete');
        $this->authorizeReserva($pago->reserva);

        $data = $request->validate([
            'metodo_pago' => ['required', 'string', 'max:50'],
            'monto' => ['required', 'numeric', 'min:0'],
            'estado_pago' => ['required', 'in:pendiente,pagado,rechazado'],
            'comprobante' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ]);

        $pago->update([
            'metodo_pago' => $data['metodo_pago'],
            'monto' => $data['monto'],
            'estado_pago' => $data['estado_pago'],
        ]);

        if ($request->hasFile('comprobante')) {
            $ruta = $request->file('comprobante')->store('comprobantes', 'public');
            $pago->comprobantes()->create([
                'ruta_archivo' => $ruta,
                'fecha_subida' => now(),
            ]);
        }

        return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy(Pago $pago): RedirectResponse
    {
        $pago->load('reserva.disponibilidad.paquete', 'comprobantes');
        $this->authorizeReserva($pago->reserva);

        foreach ($pago->comprobantes as $comprobante) {
            Storage::disk('public')->delete($comprobante->ruta_archivo);
        }

        $pago->delete();

        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');
    }

    private function authorizeReserva(Reserva $reserva): void
    {
        if ($reserva->disponibilidad->paquete->id_operador !== Auth::user()->id_operador) {
            abort(403);
        }
    }
}
