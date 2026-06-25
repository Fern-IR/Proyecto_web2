<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Panel de control</h2>
            <span class="text-sm text-gray-500">{{ $usuario->operador->nombre_comercial }}</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-flash-messages />

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="text-lg mb-1">Bienvenido, <strong>{{ $usuario->name }}</strong></p>
                <p class="text-gray-600">Operador: {{ $usuario->operador->ciudad }} · Rol: {{ $usuario->rol->nombre_rol }}</p>
            </div>

            <div class="grid md:grid-cols-4 gap-4">
                <a href="{{ route('clientes.index') }}" class="bg-white shadow-sm sm:rounded-lg p-5 border-l-4 border-emerald-500 hover:shadow-md transition">
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['clientes'] }}</p>
                    <p class="text-sm text-gray-500">Clientes</p>
                </a>
                <a href="{{ route('paquetes.index') }}" class="bg-white shadow-sm sm:rounded-lg p-5 border-l-4 border-sky-500 hover:shadow-md transition">
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['paquetes'] }}</p>
                    <p class="text-sm text-gray-500">Paquetes</p>
                </a>
                <a href="{{ route('disponibilidad.index') }}" class="bg-white shadow-sm sm:rounded-lg p-5 border-l-4 border-amber-500 hover:shadow-md transition">
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['disponibilidades'] }}</p>
                    <p class="text-sm text-gray-500">Disponibilidades</p>
                </a>
                <a href="{{ route('reservas.index') }}" class="bg-white shadow-sm sm:rounded-lg p-5 border-l-4 border-violet-500 hover:shadow-md transition">
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['reservas'] }}</p>
                    <p class="text-sm text-gray-500">Reservas</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
