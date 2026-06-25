<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function index(): View
    {
        $clientes = Cliente::forOperador()
            ->latest('id_cliente')
            ->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    public function create(): View
    {
        return view('clientes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombres' => ['required', 'string', 'max:150'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'correo' => ['nullable', 'email', 'max:150'],
            'nacionalidad' => ['nullable', 'string', 'max:80'],
        ]);

        Cliente::create([
            ...$data,
            'id_operador' => Auth::user()->id_operador,
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function edit(Cliente $cliente): View|RedirectResponse
    {
        if ($cliente->id_operador !== Auth::user()->id_operador) {
            abort(403);
        }

        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente): RedirectResponse
    {
        if ($cliente->id_operador !== Auth::user()->id_operador) {
            abort(403);
        }

        $data = $request->validate([
            'nombres' => ['required', 'string', 'max:150'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'correo' => ['nullable', 'email', 'max:150'],
            'nacionalidad' => ['nullable', 'string', 'max:80'],
        ]);

        $cliente->update($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        if ($cliente->id_operador !== Auth::user()->id_operador) {
            abort(403);
        }

        if ($cliente->reservas()->exists()) {
            return back()->with('error', 'No se puede eliminar un cliente con reservas asociadas.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}
