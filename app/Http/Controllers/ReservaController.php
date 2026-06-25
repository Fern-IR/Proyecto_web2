<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Disponibilidad;
use App\Models\Reserva;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReservaController extends Controller
{
    public function index(): View
    {
        $idOperador = Auth::user()->id_operador;

        $reservas = Reserva::query()
            ->with(['cliente', 'disponibilidad.paquete'])
            ->whereHas('disponibilidad.paquete', fn ($q) => $q->where('id_operador', $idOperador))
            ->latest('id_reserva')
            ->paginate(10);

        return view('reservas.index', compact('reservas'));
    }

    public function create(): View
    {
        $clientes = Cliente::forOperador()->orderBy('nombres')->get();
        $disponibilidades = Disponibilidad::query()
            ->with('paquete')
            ->whereHas('paquete', fn ($q) => $q->where('id_operador', Auth::user()->id_operador))
            ->where('cupos_disponibles', '>', 0)
            ->whereDate('fecha', '>=', now()->toDateString())
            ->orderBy('fecha')
            ->get();

        return view('reservas.create', compact('clientes', 'disponibilidades'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id_cliente' => ['required', 'exists:clientes,id_cliente'],
            'id_disponibilidad' => ['required', 'exists:disponibilidad,id_disponibilidad'],
            'estado' => ['required', 'in:pendiente,confirmada,cancelada,completada'],
        ]);

        $cliente = Cliente::forOperador()->findOrFail($data['id_cliente']);
        $disponibilidad = Disponibilidad::with('paquete')->findOrFail($data['id_disponibilidad']);

        if ($disponibilidad->paquete->id_operador !== Auth::user()->id_operador) {
            abort(403);
        }

        if ($disponibilidad->cupos_disponibles < 1 && in_array($data['estado'], ['pendiente', 'confirmada'], true)) {
            return back()->withInput()->with('error', 'No hay cupos disponibles para la fecha seleccionada.');
        }

        try {
            DB::transaction(function () use ($data, $disponibilidad, $cliente) {
                $montoTotal = $disponibilidad->paquete->precio;

                Reserva::create([
                    'id_cliente' => $cliente->id_cliente,
                    'id_disponibilidad' => $disponibilidad->id_disponibilidad,
                    'estado' => $data['estado'],
                    'monto_total' => $montoTotal,
                ]);

                if (in_array($data['estado'], ['pendiente', 'confirmada'], true)) {
                    $disponibilidad->decrement('cupos_disponibles');
                }
            });
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'No fue posible registrar la reserva. Inténtalo nuevamente.');
        }

        return redirect()->route('reservas.index')->with('success', 'Reserva registrada correctamente.');
    }

    public function edit(Reserva $reserva): View
    {
        $this->authorizeReserva($reserva);

        $clientes = Cliente::forOperador()->orderBy('nombres')->get();
        $disponibilidades = Disponibilidad::query()
            ->with('paquete')
            ->whereHas('paquete', fn ($q) => $q->where('id_operador', Auth::user()->id_operador))
            ->orderBy('fecha')
            ->get();

        return view('reservas.edit', compact('reserva', 'clientes', 'disponibilidades'));
    }

    public function update(Request $request, Reserva $reserva): RedirectResponse
    {
        $this->authorizeReserva($reserva);

        $data = $request->validate([
            'id_cliente' => ['required', 'exists:clientes,id_cliente'],
            'id_disponibilidad' => ['required', 'exists:disponibilidad,id_disponibilidad'],
            'estado' => ['required', 'in:pendiente,confirmada,cancelada,completada'],
        ]);

        $cliente = Cliente::forOperador()->findOrFail($data['id_cliente']);
        $disponibilidad = Disponibilidad::with('paquete')->findOrFail($data['id_disponibilidad']);

        if ($disponibilidad->paquete->id_operador !== Auth::user()->id_operador) {
            abort(403);
        }

        $estadoAnterior = $reserva->estado;
        $estadoNuevo = $data['estado'];

        try {
            DB::transaction(function () use ($reserva, $data, $cliente, $disponibilidad, $estadoAnterior, $estadoNuevo) {
                if ($reserva->id_disponibilidad !== $disponibilidad->id_disponibilidad) {
                    $this->liberarCupo($reserva);
                    if (in_array($estadoNuevo, ['pendiente', 'confirmada'], true)) {
                        if ($disponibilidad->cupos_disponibles < 1) {
                            throw new \RuntimeException('Sin cupos');
                        }
                        $disponibilidad->decrement('cupos_disponibles');
                    }
                } else {
                    $this->ajustarCupoPorEstado($reserva, $estadoAnterior, $estadoNuevo);
                }

                $reserva->update([
                    'id_cliente' => $cliente->id_cliente,
                    'id_disponibilidad' => $disponibilidad->id_disponibilidad,
                    'estado' => $estadoNuevo,
                    'monto_total' => $disponibilidad->paquete->precio,
                ]);
            });
        } catch (\RuntimeException) {
            return back()->withInput()->with('error', 'No hay cupos disponibles para completar la actualización.');
        } catch (\Throwable) {
            return back()->withInput()->with('error', 'No fue posible actualizar la reserva.');
        }

        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    public function destroy(Reserva $reserva): RedirectResponse
    {
        $this->authorizeReserva($reserva);

        try {
            DB::transaction(function () use ($reserva) {
                $this->liberarCupo($reserva);
                $reserva->delete();
            });
        } catch (\Throwable) {
            return back()->with('error', 'No fue posible eliminar la reserva.');
        }

        return redirect()->route('reservas.index')->with('success', 'Reserva eliminada correctamente.');
    }

    private function authorizeReserva(Reserva $reserva): void
    {
        $reserva->loadMissing('disponibilidad.paquete');

        if ($reserva->disponibilidad->paquete->id_operador !== Auth::user()->id_operador) {
            abort(403);
        }
    }

    private function liberarCupo(Reserva $reserva): void
    {
        if (in_array($reserva->estado, ['pendiente', 'confirmada'], true)) {
            Disponibilidad::whereKey($reserva->id_disponibilidad)->increment('cupos_disponibles');
        }
    }

    private function ajustarCupoPorEstado(Reserva $reserva, string $anterior, string $nuevo): void
    {
        $ocupa = ['pendiente', 'confirmada'];

        if (in_array($anterior, $ocupa, true) && ! in_array($nuevo, $ocupa, true)) {
            Disponibilidad::whereKey($reserva->id_disponibilidad)->increment('cupos_disponibles');
        }

        if (! in_array($anterior, $ocupa, true) && in_array($nuevo, $ocupa, true)) {
            $disponibilidad = Disponibilidad::findOrFail($reserva->id_disponibilidad);
            if ($disponibilidad->cupos_disponibles < 1) {
                throw new \RuntimeException('Sin cupos');
            }
            $disponibilidad->decrement('cupos_disponibles');
        }
    }
}
