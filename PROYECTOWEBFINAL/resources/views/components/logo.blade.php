@props(['size' => 'md', 'variant' => 'default'])

@php
    $logoUrl = asset('images/logo-bolivia-travel.png');
    $href = $attributes->get('href', route('landing'));
@endphp

@if ($variant === 'watermark')
    <img
        src="{{ $logoUrl }}"
        alt=""
        aria-hidden="true"
        {{ $attributes->except('href')->merge(['class' => 'logo-watermark pointer-events-none select-none']) }}
    >
@elseif ($variant === 'compact')
    <a href="{{ $href }}" {{ $attributes->except('href')->merge(['class' => 'inline-flex items-center shrink-0']) }}>
        <img
            src="{{ $logoUrl }}"
            alt="Bolivia Travel"
            class="h-9 w-auto max-w-[120px] object-contain object-left"
        >
    </a>
@elseif ($variant === 'footer')
    <a href="{{ $href }}" {{ $attributes->except('href')->merge(['class' => 'inline-flex items-center shrink-0']) }}>
        <img
            src="{{ $logoUrl }}"
            alt="Bolivia Travel"
            class="h-10 w-auto max-w-[130px] object-contain brightness-0 invert opacity-90"
        >
    </a>
@else
    <a href="{{ $href }}" {{ $attributes->except('href')->merge(['class' => 'inline-flex items-center shrink-0']) }}>
        <img
            src="{{ $logoUrl }}"
            alt="Bolivia Travel — Agencia de viajes"
            class="h-10 w-auto max-w-[130px] object-contain object-left"
        >
    </a>
@endif
