<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Pagos</h2>
            <a href="{{ route('pagos.create') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm hover:bg-emerald-500">Registrar pago</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reserva</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($pagos as $pago)
                            <tr>
                                <td class="px-4 py-3">
                                    #{{ $pago->id_reserva }} — {{ $pago->reserva->cliente->nombres }}<br>
                                    <span class="text-sm text-gray-500">{{ $pago->reserva->disponibilidad->paquete->nombre_paquete }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $pago->metodo_pago }}</td>
                                <td class="px-4 py-3">Bs. {{ number_format($pago->monto, 2) }}</td>
                                <td class="px-4 py-3 capitalize">{{ $pago->estado_pago }}</td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('pagos.edit', $pago) }}" class="text-indigo-600 hover:underline">Editar</a>
                                    <form action="{{ route('pagos.destroy', $pago) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar pago?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No hay pagos registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $pagos->links() }}</div>
        </div>
    </div>
</x-app-layout>
