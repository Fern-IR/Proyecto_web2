<x-guest-layout>
    <h2 class="text-lg font-semibold text-gray-800 mb-1">Crear cuenta</h2>
    <p class="text-sm text-gray-500 mb-6">Registra tu operador turístico y comienza a gestionar reservas.</p>

    @if ($errors->has('registro'))
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
            {{ $errors->first('registro') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="nombre_comercial" value="Nombre comercial del operador" />
            <x-text-input id="nombre_comercial" name="nombre_comercial" class="block mt-1 w-full" :value="old('nombre_comercial')" required autofocus />
            <x-input-error :messages="$errors->get('nombre_comercial')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="ciudad" value="Ciudad" />
            <x-text-input id="ciudad" name="ciudad" class="block mt-1 w-full" :value="old('ciudad')" required />
            <x-input-error :messages="$errors->get('ciudad')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="correo" :value="__('Email')" />
            <x-text-input id="correo" class="block mt-1 w-full" type="email" name="correo" :value="old('correo')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-password-input id="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-password-input id="password_confirmation" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ms-4">{{ __('Register') }}</x-primary-button>
        </div>
    </form>
</x-guest-layout>
