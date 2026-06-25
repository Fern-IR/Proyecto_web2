<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-travel-900">Panel de control</h2>
                <p class="text-sm text-slate-500 mt-0.5">{{ $usuario->operador->nombre_comercial }} · {{ $usuario->operador->ciudad }}</p>
            </div>
            <span class="inline-flex items-center px-4 py-2 rounded-xl bg-travel-50 border border-travel-100 text-sm text-travel-700 font-medium">
                Rol: {{ $usuario->rol->nombre_rol }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-flash-messages />

            {{-- Stats --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <a href="{{ route('paquetes.index') }}" class="stat-card-travel">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Paquetes activos</p>
                    <p class="text-3xl font-extrabold text-travel-700 mt-1">{{ $stats['paquetes'] }}</p>
                </a>
                <a href="{{ route('reservas.index') }}" class="stat-card-travel">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Reservas</p>
                    <p class="text-3xl font-extrabold text-travel-700 mt-1">{{ $stats['reservas'] }}</p>
                </a>
                <a href="{{ route('clientes.index') }}" class="stat-card-travel">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Clientes</p>
                    <p class="text-3xl font-extrabold text-travel-700 mt-1">{{ $stats['clientes'] }}</p>
                </a>
                <a href="{{ route('disponibilidad.index') }}" class="stat-card-travel">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Disponibilidades</p>
                    <p class="text-3xl font-extrabold text-travel-700 mt-1">{{ $stats['disponibilidades'] }}</p>
                </a>
                <a href="{{ route('paquetes.index') }}" class="stat-card-travel">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Destinos</p>
                    <p class="text-3xl font-extrabold text-travel-700 mt-1">{{ $stats['destinos'] }}</p>
                </a>
            </div>

            {{-- Acciones rápidas --}}
            <div class="travel-card p-6">
                <h3 class="font-semibold text-travel-900 mb-4">Acciones rápidas</h3>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <a href="{{ route('paquetes.create') }}" class="flex items-center gap-3 p-4 rounded-xl border border-slate-100 hover:border-travel-200 hover:bg-travel-50/50 transition text-sm font-medium text-slate-700">Nuevo paquete</a>
                    <a href="{{ route('reservas.create') }}" class="flex items-center gap-3 p-4 rounded-xl border border-slate-100 hover:border-travel-200 hover:bg-travel-50/50 transition text-sm font-medium text-slate-700">Nueva reserva</a>
                    <a href="{{ route('clientes.create') }}" class="flex items-center gap-3 p-4 rounded-xl border border-slate-100 hover:border-travel-200 hover:bg-travel-50/50 transition text-sm font-medium text-slate-700">Nuevo cliente</a>
                    <a href="{{ route('pagos.create') }}" class="flex items-center gap-3 p-4 rounded-xl border border-slate-100 hover:border-travel-200 hover:bg-travel-50/50 transition text-sm font-medium text-slate-700">Registrar pago</a>
                </div>
            </div>

            {{-- Tabla reservas recientes --}}
            <div class="table-travel">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-semibold text-travel-900">Reservas recientes</h3>
                    <a href="{{ route('reservas.index') }}" class="text-sm text-travel-600 hover:text-travel-800 font-medium">Ver todas</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Cliente</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Paquete</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Fecha</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Estado</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Monto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($reservasRecientes as $reserva)
                                @php
                                    $estadoClass = match($reserva->estado) {
                                        'confirmada' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                        'pendiente' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'cancelada' => 'bg-red-50 text-red-700 border-red-100',
                                        default => 'bg-sky-50 text-sky-700 border-sky-100',
                                    };
                                @endphp
                                <tr class="hover:bg-travel-50/30 transition">
                                    <td class="px-5 py-3.5 font-medium text-slate-800">{{ $reserva->cliente->nombres }}</td>
                                    <td class="px-5 py-3.5 text-sm text-slate-600">{{ $reserva->disponibilidad->paquete->nombre_paquete }}</td>
                                    <td class="px-5 py-3.5 text-sm text-slate-500">{{ $reserva->disponibilidad->fecha->format('d/m/Y') }}</td>
                                    <td class="px-5 py-3.5">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize border {{ $estadoClass }}">{{ $reserva->estado }}</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right font-semibold text-slate-800">Bs. {{ number_format($reserva->monto_total, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center text-slate-500">No hay reservas registradas. <a href="{{ route('reservas.create') }}" class="text-travel-600 hover:underline">Crear la primera</a></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
