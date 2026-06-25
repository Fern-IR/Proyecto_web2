<?php

namespace App\Http\Controllers;

use App\Models\PaqueteTuristico;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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
        $data = $this->validatedData($request);

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

        $paquete->update($this->validatedData($request));

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

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'nombre_paquete' => ['required', 'string', 'max:150'],
            'destino' => ['required', 'string', 'max:100'],
            'pais' => ['required', 'string', 'max:80'],
            'duracion_dias' => ['required', 'integer', 'min:1', 'max:365'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'tipo_viaje' => ['required', 'string', 'max:50'],
            'imagen_url' => ['nullable', 'url', 'max:500'],
            'precio' => ['required', 'numeric', 'min:0'],
            'cupo_maximo' => ['required', 'integer', 'min:1'],
            'estado' => ['required', Rule::in(['activo', 'inactivo', 'agotado'])],
        ]);
    }

    private function authorizeOperador(int $idOperador): void
    {
        if ($idOperador !== Auth::user()->id_operador) {
            abort(403);
        }
    }
}
