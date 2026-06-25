<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Disponibilidad</h2>
            <a href="{{ route('disponibilidad.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm hover:bg-emerald-500">Nueva fecha</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paquete</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cupos disponibles</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($disponibilidades as $item)
                            <tr>
                                <td class="px-4 py-3">{{ $item->paquete->nombre_paquete }}</td>
                                <td class="px-4 py-3">{{ $item->fecha->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">{{ $item->cupos_disponibles }}</td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('disponibilidad.edit', $item) }}" class="text-indigo-600 hover:underline">Editar</a>
                                    <form action="{{ route('disponibilidad.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar disponibilidad?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">No hay fechas de disponibilidad.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $disponibilidades->links() }}</div>
        </div>
    </div>
</x-app-layout>
