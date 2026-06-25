<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-travel-900">Crear cuenta</h2>
        <p class="text-sm text-slate-500 mt-1">Registra tu operador turístico y gestiona paquetes, reservas y pagos.</p>
    </div>

    @if ($errors->has('registro'))
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
            {{ $errors->first('registro') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" x-data="{ loading: false }" @submit="loading = true" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="nombre_comercial" value="Nombre comercial del operador" />
            <x-text-input id="nombre_comercial" name="nombre_comercial" class="input-travel mt-1" :value="old('nombre_comercial')" required autofocus placeholder="Ej: Bolivia Travel Tours" />
            <x-input-error :messages="$errors->get('nombre_comercial')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="ciudad" value="Ciudad" />
            <x-text-input id="ciudad" name="ciudad" class="input-travel mt-1" :value="old('ciudad')" required placeholder="Ej: La Paz" />
            <x-input-error :messages="$errors->get('ciudad')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="correo" value="Correo electrónico" />
            <x-text-input id="correo" class="input-travel mt-1" type="email" name="correo" :value="old('correo')" required autocomplete="username" placeholder="tu@email.com" />
            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Contraseña" />
            <x-password-input id="password" name="password" required autocomplete="new-password" class="input-travel" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirmar contraseña" />
            <x-password-input id="password_confirmation" name="password_confirmation" required autocomplete="new-password" class="input-travel" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">
            <a class="text-sm text-travel-600 hover:text-travel-800" href="{{ route('login') }}">¿Ya tienes cuenta?</a>
            <x-primary-button class="justify-center" x-bind:disabled="loading">
                <span x-show="!loading">Registrarse</span>
                <span x-show="loading" x-cloak class="flex items-center gap-2"><span class="spinner"></span> Creando cuenta...</span>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
