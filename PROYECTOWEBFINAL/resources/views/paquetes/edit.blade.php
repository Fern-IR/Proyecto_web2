<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-travel-900">Editar paquete turístico</h2>
    </x-slot>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="travel-card p-6">
                <form method="POST" action="{{ route('paquetes.update', $paquete) }}" class="space-y-6">
                    @csrf @method('PUT')
                    @include('paquetes._form', ['paquete' => $paquete])
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('paquetes.index') }}" class="btn-secondary px-4 py-2 text-sm">Cancelar</a>
                        <x-primary-button>Actualizar paquete</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
