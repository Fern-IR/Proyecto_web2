<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bolivia Travel — Agencia de viajes internacionales</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-sand-50 text-slate-800">

    {{-- Header --}}
    <header class="fixed top-0 inset-x-0 z-50 nav-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <x-logo variant="compact" />
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                <a href="#beneficios" class="hover:text-travel-600 transition">Beneficios</a>
                <a href="#paquetes" class="hover:text-travel-600 transition">Paquetes</a>
                <a href="#destinos" class="hover:text-travel-600 transition">Destinos</a>
                <a href="#testimonios" class="hover:text-travel-600 transition">Testimonios</a>
            </nav>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary text-sm px-5 py-2.5">Ir al panel</a>
                @else
                    <a href="{{ route('login') }}" class="btn-secondary text-sm px-5 py-2.5 hidden sm:inline-flex">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm px-5 py-2.5">Registrarse</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="relative min-h-screen flex items-center pt-20 bg-hero-travel bg-cover bg-center bg-fixed">
        <div class="overlay-hero absolute inset-0"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="max-w-2xl">
                <span class="section-badge mb-6">Agencia de viajes · Bolivia</span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-travel-900 leading-tight mb-6">
                    Tu próximo destino internacional comienza aquí
                </h1>
                <p class="text-lg sm:text-xl text-slate-600 mb-10 leading-relaxed">
                    Paquetes turísticos, asesoría personalizada y reservas seguras para viajes familiares, de negocios y aventura. Gestiona todo desde una plataforma confiable.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="btn-primary">Reservar ahora</a>
                    <a href="#paquetes" class="btn-secondary">Ver paquetes</a>
                </div>
                <div class="mt-14 grid grid-cols-3 gap-6 max-w-md">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-travel-600">{{ $stats['paquetes'] }}+</p>
                        <p class="text-xs text-slate-500 mt-1">Paquetes activos</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-travel-600">{{ $stats['destinos'] }}+</p>
                        <p class="text-xs text-slate-500 mt-1">Destinos</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-travel-600">{{ $stats['operadores'] }}+</p>
                        <p class="text-xs text-slate-500 mt-1">Operadores</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Beneficios --}}
    <section id="beneficios" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <span class="section-badge">Por qué elegirnos</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-travel-900 mt-4">Viajes con respaldo profesional</h2>
                <p class="text-slate-500 mt-3 max-w-2xl mx-auto">Cada reserva cuenta con seguimiento, precios claros y atención especializada antes, durante y después del viaje.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($beneficios as $beneficio)
                    <div class="benefit-card">
                        <div class="w-12 h-12 rounded-xl bg-travel-100 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-travel-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="font-bold text-travel-900 mb-2">{{ $beneficio['titulo'] }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">{{ $beneficio['descripcion'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Paquetes destacados --}}
    <section id="paquetes" class="py-20 bg-sand-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
                <div>
                    <span class="section-badge">Paquetes destacados</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-travel-900 mt-4">Itinerarios listos para reservar</h2>
                </div>
                @guest
                    <a href="{{ route('register') }}" class="btn-primary shrink-0">Ver paquetes</a>
                @endguest
            </div>

            @if ($paquetes->isEmpty())
                <div class="travel-card p-12 text-center">
                    <p class="text-slate-500 text-lg">Próximamente publicaremos nuevos paquetes turísticos.</p>
                    <a href="{{ route('register') }}" class="btn-primary inline-flex mt-6">Registrarse como operador</a>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($paquetes as $paquete)
                        <article class="package-card-landing group">
                            <x-travel-image
                                :src="$paquete->imagen_url"
                                :destino="$paquete->destino"
                                :alt="$paquete->nombre_paquete"
                            />
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-travel-600">{{ $paquete->tipo_viaje ?? 'Turismo' }}</span>
                                    <span class="text-xs text-slate-400">{{ $paquete->duracion_dias }} días</span>
                                </div>
                                <h3 class="font-bold text-travel-900 mb-1">{{ $paquete->nombre_paquete }}</h3>
                                <p class="text-sm text-slate-500 mb-3">{{ $paquete->destino }}, {{ $paquete->pais }}</p>
                                @if ($paquete->descripcion)
                                    <p class="text-sm text-slate-400 line-clamp-2 mb-4">{{ $paquete->descripcion }}</p>
                                @endif
                                <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                                    <span class="text-xl font-bold text-accent-600">Bs. {{ number_format($paquete->precio, 0) }}</span>
                                    <span class="text-xs text-slate-400">Cupo {{ $paquete->cupo_maximo }}</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Destinos populares --}}
    <section id="destinos" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <span class="section-badge">Destinos populares</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-travel-900 mt-4">Explora Sudamérica y más allá</h2>
            </div>
            @if ($destinos->isEmpty())
                <p class="text-center text-slate-500">Destinos disponibles próximamente.</p>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($destinos as $destino)
                        <div class="relative rounded-2xl overflow-hidden group h-64 shadow-card">
                            <x-travel-image
                                :destino="$destino->destino"
                                :alt="$destino->destino"
                                class="h-64"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-travel-900/80 via-travel-900/20 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                                <p class="text-sm opacity-80">{{ $destino->pais }}</p>
                                <h3 class="text-xl font-bold">{{ $destino->destino }}</h3>
                                <p class="text-sm mt-1 opacity-90">Desde Bs. {{ number_format($destino->precio_desde, 0) }} · {{ $destino->paquetes_count }} paquete(s)</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Testimonios --}}
    <section id="testimonios" class="py-20 bg-sand-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <span class="section-badge">Confianza</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-travel-900 mt-4">Viajeros que confían en nosotros</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($testimonios as $testimonio)
                    <blockquote class="travel-card p-6">
                        <p class="text-sm text-slate-600 leading-relaxed mb-4">"{{ $testimonio['texto'] }}"</p>
                        <footer>
                            <p class="font-semibold text-travel-900">{{ $testimonio['nombre'] }}</p>
                            <p class="text-xs text-slate-400">{{ $testimonio['ciudad'] }} · {{ $testimonio['viaje'] }}</p>
                        </footer>
                    </blockquote>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative py-24 bg-cta-travel bg-cover bg-center">
        <div class="overlay-cta absolute inset-0"></div>
        <div class="relative z-10 max-w-3xl mx-auto px-4 text-center text-white">
            <h2 class="text-3xl sm:text-4xl font-bold mb-4">Planifica tu próximo viaje con Bolivia Travel</h2>
            <p class="text-lg text-sky-100 mb-10">Regístrate como operador turístico o accede a tu panel para gestionar paquetes, reservas y pagos.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="btn-primary bg-white text-travel-800 hover:from-white hover:to-sand-100 shadow-float">Registrarse</a>
                <a href="{{ route('login') }}" class="btn-outline-light">Iniciar sesión</a>
            </div>
        </div>
    </section>

    <footer class="bg-travel-900 text-sky-200 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <x-logo variant="footer" />
            <p class="text-sm text-sky-300/70">&copy; {{ date('Y') }} Bolivia Travel. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
