<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Información del operador</h2>
        <p class="mt-1 text-sm text-gray-600">Actualiza los datos de tu operador turístico y correo de acceso.</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nombre_comercial" value="Nombre comercial" />
            <x-text-input id="nombre_comercial" name="nombre_comercial" type="text" class="mt-1 block w-full" :value="old('nombre_comercial', $user->operador->nombre_comercial)" required />
            <x-input-error class="mt-2" :messages="$errors->get('nombre_comercial')" />
        </div>

        <div>
            <x-input-label for="ciudad" value="Ciudad" />
            <x-text-input id="ciudad" name="ciudad" type="text" class="mt-1 block w-full" :value="old('ciudad', $user->operador->ciudad)" required />
            <x-input-error class="mt-2" :messages="$errors->get('ciudad')" />
        </div>

        <div>
            <x-input-label for="correo" value="Correo electrónico" />
            <x-text-input id="correo" name="correo" type="email" class="mt-1 block w-full" :value="old('correo', $user->correo)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('correo')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Guardar</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p class="text-sm text-gray-600">Guardado.</p>
            @endif
        </div>
    </form>
</section>
