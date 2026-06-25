<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Nueva disponibilidad</h2></x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($paquetes->isEmpty())
                    <p class="text-gray-600">Primero debes crear un paquete turístico.</p>
                    <a href="{{ route('paquetes.create') }}" class="inline-block mt-4 text-emerald-600 hover:underline">Crear paquete</a>
                @else
                    <form method="POST" action="{{ route('disponibilidad.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="id_paquete" value="Paquete" />
                            <select id="id_paquete" name="id_paquete" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">Seleccionar...</option>
                                @foreach ($paquetes as $paquete)
                                    <option value="{{ $paquete->id_paquete }}" @selected(old('id_paquete') == $paquete->id_paquete)>{{ $paquete->nombre_paquete }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_paquete')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="fecha" value="Fecha" />
                            <x-text-input id="fecha" name="fecha" type="date" class="block mt-1 w-full" :value="old('fecha')" required />
                            <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="cupos_disponibles" value="Cupos disponibles" />
                            <x-text-input id="cupos_disponibles" name="cupos_disponibles" type="number" min="1" class="block mt-1 w-full" :value="old('cupos_disponibles')" required />
                            <x-input-error :messages="$errors->get('cupos_disponibles')" class="mt-2" />
                        </div>
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('disponibilidad.index') }}" class="px-4 py-2 border rounded-md text-sm">Cancelar</a>
                            <x-primary-button>Guardar</x-primary-button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
