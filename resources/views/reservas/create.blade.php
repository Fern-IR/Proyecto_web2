<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Nueva reserva</h2></x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-flash-messages />
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($clientes->isEmpty() || $disponibilidades->isEmpty())
                    <p class="text-gray-600">Necesitas al menos un cliente y una disponibilidad con cupos.</p>
                @else
                    <form method="POST" action="{{ route('reservas.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="id_cliente" value="Cliente" />
                            <select id="id_cliente" name="id_cliente" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id_cliente }}" @selected(old('id_cliente') == $cliente->id_cliente)>{{ $cliente->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="id_disponibilidad" value="Paquete y fecha" />
                            <select id="id_disponibilidad" name="id_disponibilidad" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach ($disponibilidades as $item)
                                    <option value="{{ $item->id_disponibilidad }}" @selected(old('id_disponibilidad') == $item->id_disponibilidad)>
                                        {{ $item->paquete->nombre_paquete }} — {{ $item->fecha->format('d/m/Y') }} ({{ $item->cupos_disponibles }} cupos) — Bs. {{ number_format($item->paquete->precio, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="estado" value="Estado" />
                            <select id="estado" name="estado" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach (['pendiente', 'confirmada', 'cancelada', 'completada'] as $estado)
                                    <option value="{{ $estado }}" @selected(old('estado', 'pendiente') === $estado)>{{ ucfirst($estado) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('reservas.index') }}" class="px-4 py-2 border rounded-md text-sm">Cancelar</a>
                            <x-primary-button>Guardar reserva</x-primary-button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
