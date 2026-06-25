<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-travel-900">Pagos</h2>
                <p class="text-sm text-slate-500 mt-0.5">Registro de pagos y comprobantes</p>
            </div>
            <a href="{{ route('pagos.create') }}" class="btn-primary text-sm px-5 py-2.5">Registrar pago</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />
            <div class="table-travel overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Reserva</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Método</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Monto</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Estado</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($pagos as $pago)
                            @php
                                $pagoClass = match($pago->estado_pago) {
                                    'pagado' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'pendiente' => 'bg-amber-50 text-amber-700 border-amber-100',
                                    default => 'bg-red-50 text-red-700 border-red-100',
                                };
                            @endphp
                            <tr class="hover:bg-travel-50/30 transition">
                                <td class="px-5 py-4">
                                    <span class="font-medium text-slate-800">#{{ $pago->id_reserva }} — {{ $pago->reserva->cliente->nombres }}</span><br>
                                    <span class="text-sm text-slate-500">{{ $pago->reserva->disponibilidad->paquete->nombre_paquete }}</span>
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $pago->metodo_pago }}</td>
                                <td class="px-5 py-4 font-semibold text-slate-800">Bs. {{ number_format($pago->monto, 2) }}</td>
                                <td class="px-5 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize border {{ $pagoClass }}">{{ $pago->estado_pago }}</span></td>
                                <td class="px-5 py-4 text-right space-x-3">
                                    <a href="{{ route('pagos.edit', $pago) }}" class="text-travel-600 hover:text-travel-800 font-medium text-sm">Editar</a>
                                    <form action="{{ route('pagos.destroy', $pago) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar pago?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-16 text-center text-slate-500">No hay pagos registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $pagos->links() }}</div>
        </div>
    </div>
</x-app-layout>
