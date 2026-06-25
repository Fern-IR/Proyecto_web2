<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Editar disponibilidad</h2></x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('disponibilidad.update', $disponibilidad) }}" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <x-input-label for="id_paquete" value="Paquete" />
                        <select id="id_paquete" name="id_paquete" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach ($paquetes as $paquete)
                                <option value="{{ $paquete->id_paquete }}" @selected(old('id_paquete', $disponibilidad->id_paquete) == $paquete->id_paquete)>{{ $paquete->nombre_paquete }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-input-label for="fecha" value="Fecha" />
                        <x-text-input id="fecha" name="fecha" type="date" class="block mt-1 w-full" :value="old('fecha', $disponibilidad->fecha->format('Y-m-d'))" required />
                    </div>
                    <div>
                        <x-input-label for="cupos_disponibles" value="Cupos disponibles" />
                        <x-text-input id="cupos_disponibles" name="cupos_disponibles" type="number" min="0" class="block mt-1 w-full" :value="old('cupos_disponibles', $disponibilidad->cupos_disponibles)" required />
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('disponibilidad.index') }}" class="px-4 py-2 border rounded-md text-sm">Cancelar</a>
                        <x-primary-button>Actualizar</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
