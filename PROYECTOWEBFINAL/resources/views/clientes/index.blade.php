<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-travel-900">Clientes</h2>
                <p class="text-sm text-slate-500 mt-0.5">Viajeros registrados en tu operador</p>
            </div>
            <a href="{{ route('clientes.create') }}" class="btn-primary text-sm px-5 py-2.5">Nuevo cliente</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />
            <div class="table-travel overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Nombres</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Teléfono</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Correo</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Nacionalidad</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($clientes as $cliente)
                            <tr class="hover:bg-travel-50/30 transition">
                                <td class="px-5 py-4 font-medium text-slate-800">{{ $cliente->nombres }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $cliente->telefono ?? '—' }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $cliente->correo ?? '—' }}</td>
                                <td class="px-5 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs bg-travel-50 text-travel-700 border border-travel-100">{{ $cliente->nacionalidad ?? '—' }}</span></td>
                                <td class="px-5 py-4 text-right space-x-3">
                                    <a href="{{ route('clientes.edit', $cliente) }}" class="text-travel-600 hover:text-travel-800 font-medium text-sm">Editar</a>
                                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este cliente?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-16 text-center text-slate-500">No hay clientes registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $clientes->links() }}</div>
        </div>
    </div>
</x-app-layout>
