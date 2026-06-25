<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-travel-900">Paquetes turísticos</h2>
                <p class="text-sm text-slate-500 mt-0.5">Gestión del catálogo de viajes</p>
            </div>
            <a href="{{ route('paquetes.create') }}" class="btn-primary text-sm px-5 py-2.5">Nuevo paquete</a>
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
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Destino</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Tipo</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Precio</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Estado</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($paquetes as $paquete)
                            @php
                                $estadoClass = match($paquete->estado) {
                                    'activo' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'agotado' => 'bg-red-50 text-red-700 border-red-100',
                                    default => 'bg-slate-50 text-slate-600 border-slate-100',
                                };
                            @endphp
                            <tr class="hover:bg-travel-50/30 transition">
                                <td class="px-5 py-4">
                                    <p class="font-medium text-slate-800">{{ $paquete->nombre_paquete }}</p>
                                    <p class="text-xs text-slate-400">{{ $paquete->duracion_dias }} días · Cupo {{ $paquete->cupo_maximo }}</p>
                                </td>
                                <td class="px-5 py-4 text-sm text-slate-600">{{ $paquete->destino }}, {{ $paquete->pais }}</td>
                                <td class="px-5 py-4 text-sm text-slate-500">{{ $paquete->tipo_viaje }}</td>
                                <td class="px-5 py-4 font-semibold text-accent-600">Bs. {{ number_format($paquete->precio, 2) }}</td>
                                <td class="px-5 py-4">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize border {{ $estadoClass }}">{{ $paquete->estado }}</span>
                                </td>
                                <td class="px-5 py-4 text-right space-x-3">
                                    <a href="{{ route('paquetes.edit', $paquete) }}" class="text-travel-600 hover:text-travel-800 font-medium text-sm">Editar</a>
                                    <form action="{{ route('paquetes.destroy', $paquete) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este paquete?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-16 text-center text-slate-500">No hay paquetes registrados. <a href="{{ route('paquetes.create') }}" class="text-travel-600 hover:underline">Crear el primero</a></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $paquetes->links() }}</div>
        </div>
    </div>
</x-app-layout>
