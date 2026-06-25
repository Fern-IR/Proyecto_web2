<nav x-data="{ open: false }" class="nav-header sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <x-logo variant="compact" href="{{ route('dashboard') }}" />
                <div class="hidden sm:flex items-center gap-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Panel</x-nav-link>
                    <x-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')">Clientes</x-nav-link>
                    <x-nav-link :href="route('paquetes.index')" :active="request()->routeIs('paquetes.*')">Paquetes</x-nav-link>
                    <x-nav-link :href="route('disponibilidad.index')" :active="request()->routeIs('disponibilidad.*')">Disponibilidad</x-nav-link>
                    <x-nav-link :href="route('reservas.index')" :active="request()->routeIs('reservas.*')">Reservas</x-nav-link>
                    <x-nav-link :href="route('pagos.index')" :active="request()->routeIs('pagos.*')">Pagos</x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-slate-600 bg-slate-50 border border-slate-200 hover:bg-white hover:shadow-sm transition">
                            <span class="w-8 h-8 rounded-lg bg-travel-100 text-travel-700 flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            {{ Auth::user()->name }}
                            <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-lg text-slate-500 hover:bg-slate-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-slate-100 bg-white">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Panel</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')">Clientes</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('paquetes.index')" :active="request()->routeIs('paquetes.*')">Paquetes</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('disponibilidad.index')" :active="request()->routeIs('disponibilidad.*')">Disponibilidad</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reservas.index')" :active="request()->routeIs('reservas.*')">Reservas</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pagos.index')" :active="request()->routeIs('pagos.*')">Pagos</x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-3 border-t border-slate-100 px-4">
            <p class="font-medium text-slate-800">{{ Auth::user()->name }}</p>
            <p class="text-sm text-slate-500">{{ Auth::user()->correo }}</p>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Perfil</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Cerrar sesión</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
