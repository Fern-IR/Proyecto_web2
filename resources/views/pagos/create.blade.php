<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Registrar pago</h2></x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($reservas->isEmpty())
                    <p class="text-gray-600">No hay reservas pendientes o confirmadas para registrar pagos.</p>
                @else
                    <form method="POST" action="{{ route('pagos.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="id_reserva" value="Reserva" />
                            <select id="id_reserva" name="id_reserva" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach ($reservas as $reserva)
                                    <option value="{{ $reserva->id_reserva }}" @selected(old('id_reserva', $selectedReserva) == $reserva->id_reserva)>
                                        #{{ $reserva->id_reserva }} — {{ $reserva->cliente->nombres }} — Bs. {{ number_format($reserva->monto_total, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="metodo_pago" value="Método de pago" />
                            <x-text-input id="metodo_pago" name="metodo_pago" class="block mt-1 w-full" :value="old('metodo_pago')" placeholder="Efectivo, QR, transferencia..." required />
                        </div>
                        <div>
                            <x-input-label for="monto" value="Monto (Bs.)" />
                            <x-text-input id="monto" name="monto" type="number" step="0.01" min="0" class="block mt-1 w-full" :value="old('monto')" required />
                        </div>
                        <div>
                            <x-input-label for="estado_pago" value="Estado del pago" />
                            <select id="estado_pago" name="estado_pago" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach (['pendiente', 'pagado', 'rechazado'] as $estado)
                                    <option value="{{ $estado }}" @selected(old('estado_pago', 'pendiente') === $estado)>{{ ucfirst($estado) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="comprobante" value="Comprobante (opcional)" />
                            <input id="comprobante" name="comprobante" type="file" accept=".pdf,.jpg,.jpeg,.png" class="block mt-1 w-full text-sm" />
                        </div>
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('pagos.index') }}" class="px-4 py-2 border rounded-md text-sm">Cancelar</a>
                            <x-primary-button>Guardar pago</x-primary-button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
