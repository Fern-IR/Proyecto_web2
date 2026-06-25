<?php

namespace App\Http\Controllers;

use App\Models\PaqueteTuristico;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaqueteTuristicoController extends Controller
{
    public function index(): View
    {
        $paquetes = PaqueteTuristico::forOperador()
            ->withCount('disponibilidades')
            ->latest('id_paquete')
            ->paginate(10);

        return view('paquetes.index', compact('paquetes'));
    }

    public function create(): View
    {
        return view('paquetes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre_paquete' => ['required', 'string', 'max:150'],
            'precio' => ['required', 'numeric', 'min:0'],
            'cupo_maximo' => ['required', 'integer', 'min:1'],
        ]);

        PaqueteTuristico::create([
            ...$data,
            'id_operador' => Auth::user()->id_operador,
        ]);

        return redirect()->route('paquetes.index')->with('success', 'Paquete turístico creado correctamente.');
    }

    public function edit(PaqueteTuristico $paquete): View
    {
        $this->authorizeOperador($paquete->id_operador);

        return view('paquetes.edit', compact('paquete'));
    }

    public function update(Request $request, PaqueteTuristico $paquete): RedirectResponse
    {
        $this->authorizeOperador($paquete->id_operador);

        $data = $request->validate([
            'nombre_paquete' => ['required', 'string', 'max:150'],
            'precio' => ['required', 'numeric', 'min:0'],
            'cupo_maximo' => ['required', 'integer', 'min:1'],
        ]);

        $paquete->update($data);

        return redirect()->route('paquetes.index')->with('success', 'Paquete turístico actualizado correctamente.');
    }

    public function destroy(PaqueteTuristico $paquete): RedirectResponse
    {
        $this->authorizeOperador($paquete->id_operador);

        if ($paquete->disponibilidades()->whereHas('reservas')->exists()) {
            return back()->with('error', 'No se puede eliminar un paquete con reservas asociadas.');
        }

        $paquete->delete();

        return redirect()->route('paquetes.index')->with('success', 'Paquete turístico eliminado correctamente.');
    }

    private function authorizeOperador(int $idOperador): void
    {
        if ($idOperador !== Auth::user()->id_operador) {
            abort(403);
        }
    }
}
