<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — Gestión de reservas turísticas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-950 text-white" style="background-color:#020617;color:#ffffff;">
    <header class="border-b border-white/10">
        <div class="max-w-6xl mx-auto px-6 py-5 flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-emerald-400">SaaS multitenant</p>
                <h1 class="text-2xl font-semibold">{{ config('app.name') }}</h1>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg bg-emerald-500 text-slate-950 font-medium hover:bg-emerald-400 transition">Ir al panel</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg border border-white/20 hover:bg-white/5 transition">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-emerald-500 text-slate-950 font-medium hover:bg-emerald-400 transition">Registrarse</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <section class="max-w-6xl mx-auto px-6 py-16 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <p class="text-emerald-400 font-medium mb-3">Operadores turísticos en Bolivia</p>
                <h2 class="text-4xl md:text-5xl font-bold leading-tight mb-6">Digitaliza reservas, clientes y pagos en un solo lugar.</h2>
                <p class="text-lg text-slate-300 mb-8">Plataforma SaaS con aislamiento de datos por operador turístico.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="px-6 py-3 rounded-xl bg-emerald-500 text-slate-950 font-semibold hover:bg-emerald-400 transition">Crear cuenta gratuita</a>
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl border border-white/20 hover:bg-white/5 transition">Ya tengo cuenta</a>
                </div>
            </div>
            <div class="bg-white/5 border border-white/10 rounded-2xl p-8">
                <h3 class="text-xl font-semibold mb-4">Paquetes disponibles</h3>
                @if ($paquetes->isEmpty())
                    <p class="text-slate-300">Aún no hay paquetes publicados. Regístrate como operador y crea el primero.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($paquetes as $paquete)
                            <li class="border-b border-white/10 pb-4 last:border-0 last:pb-0">
                                <p class="font-semibold">{{ $paquete->nombre_paquete }}</p>
                                <p class="text-sm text-slate-300">{{ $paquete->operador->nombre_comercial }} · {{ $paquete->operador->ciudad }}</p>
                                <p class="text-emerald-400 mt-1">Bs. {{ number_format($paquete->precio, 2) }} · Cupo: {{ $paquete->cupo_maximo }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>
    </main>

    <footer class="border-t border-white/10 py-6 text-center text-sm text-slate-400">
        &copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
    </footer>
</body>
</html>
