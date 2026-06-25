<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Nuevo cliente</h2></x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('clientes.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="nombres" value="Nombres" />
                        <x-text-input id="nombres" name="nombres" class="block mt-1 w-full" :value="old('nombres')" required />
                        <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="telefono" value="Teléfono" />
                        <x-text-input id="telefono" name="telefono" class="block mt-1 w-full" :value="old('telefono')" />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="correo" value="Correo" />
                        <x-text-input id="correo" name="correo" type="email" class="block mt-1 w-full" :value="old('correo')" />
                        <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="nacionalidad" value="Nacionalidad" />
                        <x-text-input id="nacionalidad" name="nacionalidad" class="block mt-1 w-full" :value="old('nacionalidad')" />
                        <x-input-error :messages="$errors->get('nacionalidad')" class="mt-2" />
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('clientes.index') }}" class="px-4 py-2 border rounded-md text-sm">Cancelar</a>
                        <x-primary-button>Guardar</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
