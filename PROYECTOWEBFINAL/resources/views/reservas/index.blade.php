<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-travel-900">Reservas</h2>
                <p class="text-sm text-slate-500 mt-0.5">Reservaciones de clientes en tus paquetes</p>
            </div>
            <a href="{{ route('reservas.create') }}" class="btn-primary text-sm px-5 py-2.5">Nueva reserva</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />
            <div class="table-travel overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Cliente</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Paquete / Fecha</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Estado</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Monto</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($reservas as $reserva)
                            @php
                                $estadoClass = match($reserva->estado) {
                                    'confirmada' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'pendiente' => 'bg-amber-50 text-amber-700 border-amber-100',
                                    'cancelada' => 'bg-red-50 text-red-700 border-red-100',
                                    default => 'bg-sky-50 text-sky-700 border-sky-100',
                                };
                            @endphp
                            <tr class="hover:bg-travel-50/30 transition">
                                <td class="px-5 py-4 font-medium text-slate-800">{{ $reserva->cliente->nombres }}</td>
                                <td class="px-5 py-4">
                                    <span class="text-slate-800">{{ $reserva->disponibilidad->paquete->nombre_paquete }}</span><br>
                                    <span class="text-sm text-slate-500">{{ $reserva->disponibilidad->fecha->format('d/m/Y') }}</span>
                                </td>
                                <td class="px-5 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize border {{ $estadoClass }}">{{ $reserva->estado }}</span></td>
                                <td class="px-5 py-4 font-semibold text-slate-800">Bs. {{ number_format($reserva->monto_total, 2) }}</td>
                                <td class="px-5 py-4 text-right space-x-3">
                                    <a href="{{ route('reservas.edit', $reserva) }}" class="text-travel-600 hover:text-travel-800 font-medium text-sm">Editar</a>
                                    <a href="{{ route('pagos.create', ['reserva' => $reserva->id_reserva]) }}" class="text-accent-600 hover:text-accent-700 font-medium text-sm">Pago</a>
                                    <form action="{{ route('reservas.destroy', $reserva) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar reserva?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-16 text-center text-slate-500">No hay reservas registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $reservas->links() }}</div>
        </div>
    </div>
</x-app-layout>
