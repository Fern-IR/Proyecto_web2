<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bolivia Travel — Acceso</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-800 antialiased">
    @php
        $fondoPanel = config('travel.auth_fondos.familia_viaje');
        $fondoFormulario = config('travel.auth_fondos.familia_playa');
    @endphp

    <div class="min-h-screen flex">
        {{-- Panel visual izquierdo (escritorio) — familia disfrutando viaje --}}
        <div class="auth-visual-panel" style="background-image: url('{{ $fondoPanel }}');">
            <div class="absolute inset-0 bg-gradient-to-br from-travel-900/75 via-travel-800/65 to-travel-600/55"></div>
            <x-logo variant="watermark" class="logo-watermark-panel !right-12 !bottom-12 !left-auto !top-auto !translate-x-0 !translate-y-0 !w-56 !opacity-[0.07]" />
            <div class="relative z-10 flex flex-col justify-between p-12 text-white w-full">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-widest text-sky-200/80">Bolivia Travel</p>
                    <p class="text-xs text-sky-300/60 mt-1">Agencia de viajes internacionales</p>
                </div>
                <div>
                    <h2 class="text-3xl font-bold mb-4 leading-tight">Gestiona reservas, paquetes y clientes desde un solo lugar</h2>
                    <p class="text-sky-100 text-lg leading-relaxed max-w-md">Plataforma SaaS para operadores turísticos con reservas seguras, control de disponibilidad y registro de pagos.</p>
                    <ul class="mt-8 space-y-3 text-sm text-sky-100">
                        <li class="flex items-center gap-2"><svg class="w-5 h-5 text-accent-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Paquetes nacionales e internacionales</li>
                        <li class="flex items-center gap-2"><svg class="w-5 h-5 text-accent-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Asesoría y seguimiento de reservas</li>
                        <li class="flex items-center gap-2"><svg class="w-5 h-5 text-accent-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Datos aislados por operador</li>
                    </ul>
                </div>
                <p class="text-xs text-sky-200/60">&copy; {{ date('Y') }} Bolivia Travel</p>
            </div>
        </div>

        {{-- Formulario con fondo de familia en viaje (overlay suave como landing) --}}
        <div class="auth-form-panel" style="background-image: url('{{ $fondoFormulario }}');">
            <div class="overlay-auth-light absolute inset-0"></div>
            <x-logo variant="watermark" />

            <div class="absolute top-5 left-5 z-20 lg:hidden">
                <x-logo variant="compact" />
            </div>

            <div class="auth-card-3d relative z-10 mt-8 lg:mt-0">
                {{ $slot }}
            </div>

            <p class="relative z-10 mt-6 text-sm text-slate-500">
                <a href="{{ route('landing') }}" class="text-travel-600 hover:text-travel-800 font-medium transition">&larr; Volver al inicio</a>
            </p>
        </div>
    </div>
</body>
</html>
