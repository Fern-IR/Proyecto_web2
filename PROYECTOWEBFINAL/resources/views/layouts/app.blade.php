<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bolivia Travel — Panel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-sand-50 text-slate-800">
    <div class="min-h-screen relative">
        <div class="absolute inset-0 bg-panel-light bg-cover bg-center bg-fixed opacity-30 pointer-events-none"></div>
        <div class="overlay-panel absolute inset-0 pointer-events-none"></div>

        <div class="relative z-10 min-h-screen flex flex-col">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white/80 backdrop-blur-sm border-b border-slate-100">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
