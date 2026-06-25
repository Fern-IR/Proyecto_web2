<?php

namespace App\Http\Controllers;

use App\Models\Disponibilidad;
use App\Models\PaqueteTuristico;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DisponibilidadController extends Controller
{
    public function index(): View
    {
        $idOperador = Auth::user()->id_operador;

        $disponibilidades = Disponibilidad::query()
            ->with('paquete')
            ->whereHas('paquete', fn ($q) => $q->where('id_operador', $idOperador))
            ->latest('fecha')
            ->paginate(10);

        return view('disponibilidad.index', compact('disponibilidades'));
    }

    public function create(): View
    {
        $paquetes = PaqueteTuristico::forOperador()->orderBy('nombre_paquete')->get();

        return view('disponibilidad.create', compact('paquetes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id_paquete' => ['required', 'exists:paquetes_turisticos,id_paquete'],
            'fecha' => ['required', 'date', 'after_or_equal:today'],
            'cupos_disponibles' => ['required', 'integer', 'min:1'],
        ]);

        $paquete = PaqueteTuristico::forOperador()->findOrFail($data['id_paquete']);

        if ($data['cupos_disponibles'] > $paquete->cupo_maximo) {
            return back()->withInput()->withErrors([
                'cupos_disponibles' => 'Los cupos no pueden superar el cupo máximo del paquete ('.$paquete->cupo_maximo.').',
            ]);
        }

        Disponibilidad::create($data);

        return redirect()->route('disponibilidad.index')->with('success', 'Disponibilidad registrada correctamente.');
    }

    public function edit(Disponibilidad $disponibilidad): View
    {
        $this->authorizeDisponibilidad($disponibilidad);

        $paquetes = PaqueteTuristico::forOperador()->orderBy('nombre_paquete')->get();

        return view('disponibilidad.edit', compact('disponibilidad', 'paquetes'));
    }

    public function update(Request $request, Disponibilidad $disponibilidad): RedirectResponse
    {
        $this->authorizeDisponibilidad($disponibilidad);

        $data = $request->validate([
            'id_paquete' => ['required', 'exists:paquetes_turisticos,id_paquete'],
            'fecha' => ['required', 'date'],
            'cupos_disponibles' => ['required', 'integer', 'min:0'],
        ]);

        $paquete = PaqueteTuristico::forOperador()->findOrFail($data['id_paquete']);

        $reservasActivas = $disponibilidad->reservas()
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->count();

        if ($data['cupos_disponibles'] + $reservasActivas > $paquete->cupo_maximo) {
            return back()->withInput()->withErrors([
                'cupos_disponibles' => 'La disponibilidad supera el cupo máximo del paquete.',
            ]);
        }

        $disponibilidad->update($data);

        return redirect()->route('disponibilidad.index')->with('success', 'Disponibilidad actualizada correctamente.');
    }

    public function destroy(Disponibilidad $disponibilidad): RedirectResponse
    {
        $this->authorizeDisponibilidad($disponibilidad);

        if ($disponibilidad->reservas()->exists()) {
            return back()->with('error', 'No se puede eliminar una disponibilidad con reservas asociadas.');
        }

        $disponibilidad->delete();

        return redirect()->route('disponibilidad.index')->with('success', 'Disponibilidad eliminada correctamente.');
    }

    private function authorizeDisponibilidad(Disponibilidad $disponibilidad): void
    {
        $disponibilidad->loadMissing('paquete');

        if ($disponibilidad->paquete->id_operador !== Auth::user()->id_operador) {
            abort(403);
        }
    }
}
