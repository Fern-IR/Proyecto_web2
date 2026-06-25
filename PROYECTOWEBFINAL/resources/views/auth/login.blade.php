<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-travel-900">Iniciar sesión</h2>
        <p class="text-sm text-slate-500 mt-1">Accede a tu panel de operador turístico.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{ loading: false }" @submit="loading = true" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="correo" value="Correo electrónico" />
            <x-text-input id="correo" class="input-travel mt-1" type="email" name="correo" :value="old('correo')" required autofocus autocomplete="username" placeholder="tu@email.com" />
            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Contraseña" />
            <x-password-input id="password" name="password" required autocomplete="current-password" class="input-travel" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-travel-600 focus:ring-travel-500" name="remember">
            <label for="remember_me" class="ms-2 text-sm text-slate-600">Recordarme</label>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">
            @if (Route::has('password.request'))
                <a class="text-sm text-travel-600 hover:text-travel-800" href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            @endif
            <x-primary-button class="justify-center" x-bind:disabled="loading">
                <span x-show="!loading">Iniciar sesión</span>
                <span x-show="loading" x-cloak class="flex items-center gap-2"><span class="spinner"></span> Verificando...</span>
            </x-primary-button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        ¿No tienes cuenta?
        <a href="{{ route('register') }}" class="text-travel-600 font-semibold hover:text-travel-800">Registrarse</a>
    </p>
</x-guest-layout>
