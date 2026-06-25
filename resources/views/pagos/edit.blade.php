<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Editar pago</h2></x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('pagos.update', $pago) }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PUT')
                    <div class="text-sm text-gray-600 mb-2">Reserva #{{ $pago->id_reserva }} — {{ $pago->reserva->cliente->nombres }}</div>
                    <div>
                        <x-input-label for="metodo_pago" value="Método de pago" />
                        <x-text-input id="metodo_pago" name="metodo_pago" class="block mt-1 w-full" :value="old('metodo_pago', $pago->metodo_pago)" required />
                    </div>
                    <div>
                        <x-input-label for="monto" value="Monto (Bs.)" />
                        <x-text-input id="monto" name="monto" type="number" step="0.01" min="0" class="block mt-1 w-full" :value="old('monto', $pago->monto)" required />
                    </div>
                    <div>
                        <x-input-label for="estado_pago" value="Estado del pago" />
                        <select id="estado_pago" name="estado_pago" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach (['pendiente', 'pagado', 'rechazado'] as $estado)
                                <option value="{{ $estado }}" @selected(old('estado_pago', $pago->estado_pago) === $estado)>{{ ucfirst($estado) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="comprobante" value="Nuevo comprobante (opcional)" />
                        <input id="comprobante" name="comprobante" type="file" accept=".pdf,.jpg,.jpeg,.png" class="block mt-1 w-full text-sm" />
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('pagos.index') }}" class="px-4 py-2 border rounded-md text-sm">Cancelar</a>
                        <x-primary-button>Actualizar</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
