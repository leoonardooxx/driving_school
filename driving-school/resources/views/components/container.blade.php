@props([
    'theme' => 'black',
])

@php
    $themes = [
        'black' =>
            'text-white/90 bg-white/5 border-white/20 shadow-[inset_0_1px_1px_rgba(255,255,255,0.35),inset_0_-1px_1px_rgba(0,0,0,0.4),0_4px_12px_rgba(0,0,0,0.5)]',
        'white' =>
            'text-black bg-black/5 border-black/10 shadow-[inset_0_1px_1px_rgba(255,255,255,0.8),inset_0_-1px_1px_rgba(0,0,0,0.1),0_4px_12px_rgba(0,0,0,0.15)]',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-3xl p-4 backdrop-blur-md border ' . $themes[$theme]]) }}>
    {{ $slot }}
</div>
