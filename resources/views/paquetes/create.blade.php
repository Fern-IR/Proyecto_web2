<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Nuevo paquete turístico</h2></x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('paquetes.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="nombre_paquete" value="Nombre del paquete" />
                        <x-text-input id="nombre_paquete" name="nombre_paquete" class="block mt-1 w-full" :value="old('nombre_paquete')" required />
                        <x-input-error :messages="$errors->get('nombre_paquete')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="precio" value="Precio (Bs.)" />
                        <x-text-input id="precio" name="precio" type="number" step="0.01" min="0" class="block mt-1 w-full" :value="old('precio')" required />
                        <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="cupo_maximo" value="Cupo máximo" />
                        <x-text-input id="cupo_maximo" name="cupo_maximo" type="number" min="1" class="block mt-1 w-full" :value="old('cupo_maximo')" required />
                        <x-input-error :messages="$errors->get('cupo_maximo')" class="mt-2" />
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('paquetes.index') }}" class="px-4 py-2 border rounded-md text-sm">Cancelar</a>
                        <x-primary-button>Guardar</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
