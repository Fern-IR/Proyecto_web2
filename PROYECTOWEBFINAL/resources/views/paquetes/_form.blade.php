@props(['paquete' => null])

<div class="grid sm:grid-cols-2 gap-4">
    <div class="sm:col-span-2">
        <x-input-label for="nombre_paquete" value="Nombre del paquete" />
        <x-text-input id="nombre_paquete" name="nombre_paquete" class="input-travel mt-1 w-full" :value="old('nombre_paquete', $paquete?->nombre_paquete)" required />
        <x-input-error :messages="$errors->get('nombre_paquete')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="destino" value="Destino" />
        <x-text-input id="destino" name="destino" class="input-travel mt-1 w-full" :value="old('destino', $paquete?->destino)" required placeholder="Ej: Uyuni" />
        <x-input-error :messages="$errors->get('destino')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="pais" value="País" />
        <x-text-input id="pais" name="pais" class="input-travel mt-1 w-full" :value="old('pais', $paquete?->pais)" required placeholder="Ej: Bolivia" />
        <x-input-error :messages="$errors->get('pais')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="duracion_dias" value="Duración (días)" />
        <x-text-input id="duracion_dias" name="duracion_dias" type="number" min="1" class="input-travel mt-1 w-full" :value="old('duracion_dias', $paquete?->duracion_dias)" required />
        <x-input-error :messages="$errors->get('duracion_dias')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="tipo_viaje" value="Tipo de viaje" />
        <x-text-input id="tipo_viaje" name="tipo_viaje" class="input-travel mt-1 w-full" :value="old('tipo_viaje', $paquete?->tipo_viaje)" required placeholder="Ej: Internacional" />
        <x-input-error :messages="$errors->get('tipo_viaje')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="precio" value="Precio (Bs.)" />
        <x-text-input id="precio" name="precio" type="number" step="0.01" min="0" class="input-travel mt-1 w-full" :value="old('precio', $paquete?->precio)" required />
        <x-input-error :messages="$errors->get('precio')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="cupo_maximo" value="Cupo máximo" />
        <x-text-input id="cupo_maximo" name="cupo_maximo" type="number" min="1" class="input-travel mt-1 w-full" :value="old('cupo_maximo', $paquete?->cupo_maximo)" required />
        <x-input-error :messages="$errors->get('cupo_maximo')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="estado" value="Estado" />
        <select id="estado" name="estado" class="input-travel mt-1 w-full" required>
            @foreach (['activo', 'inactivo', 'agotado'] as $estado)
                <option value="{{ $estado }}" @selected(old('estado', $paquete?->estado ?? 'activo') === $estado)>{{ ucfirst($estado) }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('estado')" class="mt-2" />
    </div>
    <div class="sm:col-span-2">
        <x-input-label for="imagen_url" value="URL de imagen (opcional)" />
        <x-text-input id="imagen_url" name="imagen_url" type="url" class="input-travel mt-1 w-full" :value="old('imagen_url', $paquete?->imagen_url)" placeholder="https://..." />
        <x-input-error :messages="$errors->get('imagen_url')" class="mt-2" />
    </div>
    <div class="sm:col-span-2">
        <x-input-label for="descripcion" value="Descripción corta" />
        <textarea id="descripcion" name="descripcion" rows="3" class="input-travel mt-1 w-full" placeholder="Describe el itinerario...">{{ old('descripcion', $paquete?->descripcion) }}</textarea>
        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
    </div>
</div>
