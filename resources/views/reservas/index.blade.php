<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Reservas</h2>
            <a href="{{ route('reservas.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm hover:bg-emerald-500">Nueva reserva</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paquete / Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto (Bs.)</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($reservas as $reserva)
                            <tr>
                                <td class="px-4 py-3">{{ $reserva->cliente->nombres }}</td>
                                <td class="px-4 py-3">
                                    {{ $reserva->disponibilidad->paquete->nombre_paquete }}<br>
                                    <span class="text-sm text-gray-500">{{ $reserva->disponibilidad->fecha->format('d/m/Y') }}</span>
                                </td>
                                <td class="px-4 py-3 capitalize">{{ $reserva->estado }}</td>
                                <td class="px-4 py-3">{{ number_format($reserva->monto_total, 2) }}</td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('reservas.edit', $reserva) }}" class="text-indigo-600 hover:underline">Editar</a>
                                    <a href="{{ route('pagos.create', ['reserva' => $reserva->id_reserva]) }}" class="text-emerald-600 hover:underline">Pago</a>
                                    <form action="{{ route('reservas.destroy', $reserva) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar reserva?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No hay reservas registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $reservas->links() }}</div>
        </div>
    </div>
</x-app-layout>
