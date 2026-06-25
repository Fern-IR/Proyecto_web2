@props([
    'src' => null,
    'destino' => null,
    'alt' => '',
    'class' => 'aspect-[4/3]',
])

@php
    use App\Support\TravelImages;
    $default = config('travel.imagen_default');
    $imageSrc = TravelImages::resolve($destino, $src);
@endphp

<div {{ $attributes->merge(['class' => $class . ' bg-gradient-to-br from-travel-100 to-travel-200 overflow-hidden relative']) }}>
    <img
        src="{{ $imageSrc }}"
        alt="{{ $alt }}"
        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
        loading="lazy"
        data-fallback="{{ $default }}"
        onerror="if(this.src!==this.dataset.fallback){this.src=this.dataset.fallback;}"
    >
</div>
