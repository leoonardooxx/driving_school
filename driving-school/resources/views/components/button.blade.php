@props([
    'type' => 'button',
    'theme' => 'black',
    'color' => 'school_color',
])
@php
    $themes = [
        'black' =>
            'text-white/90 bg-white/5 border-white/20 hover:bg-white/10 shadow-[inset_0_1px_1px_rgba(255,255,255,0.35),inset_0_-1px_1px_rgba(0,0,0,0.4),0_4px_12px_rgba(0,0,0,0.5)]',
        'white' =>
            'text-black bg-black/5 border-black/10 hover:bg-black/10 shadow-[inset_0_1px_1px_rgba(255,255,255,0.8),inset_0_-1px_1px_rgba(0,0,0,0.1),0_4px_12px_rgba(0,0,0,0.15)]',
    ];
    if ($color === 'school_color') {
        $themes[$theme] = 'text-white bg-school/85 border-white/25 hover:bg-school shadow-[inset_0_1px_1px_rgba(255,255,255,0.45),inset_0_-1px_1px_rgba(0,0,0,0.2),0_4px_12px_rgba(232,90,49,0.35)]';
    }
@endphp
<button type="{{ $type }}" {{ $attributes->merge(['class' => 'rounded-full py-3 px-6 backdrop-blur-md border transition cursor-pointer ' . $themes[$theme]]) }}>
    {{ $slot }}
</button>
