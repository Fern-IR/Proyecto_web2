<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-travel-900">Disponibilidad</h2>
                <p class="text-sm text-slate-500 mt-0.5">Fechas y cupos por paquete turístico</p>
            </div>
            <a href="{{ route('disponibilidad.create') }}" class="btn-primary text-sm px-5 py-2.5">Nueva fecha</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />
            <div class="table-travel overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Paquete</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Fecha</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Cupos</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($disponibilidades as $item)
                            <tr class="hover:bg-travel-50/30 transition">
                                <td class="px-5 py-4 font-medium text-slate-800">{{ $item->paquete->nombre_paquete }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $item->fecha->format('d/m/Y') }}</td>
                                <td class="px-5 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->cupos_disponibles > 5 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }}">{{ $item->cupos_disponibles }} disponibles</span>
                                </td>
                                <td class="px-5 py-4 text-right space-x-3">
                                    <a href="{{ route('disponibilidad.edit', $item) }}" class="text-travel-600 hover:text-travel-800 font-medium text-sm">Editar</a>
                                    <form action="{{ route('disponibilidad.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar disponibilidad?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-16 text-center text-slate-500">No hay fechas de disponibilidad.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $disponibilidades->links() }}</div>
        </div>
    </div>
</x-app-layout>
