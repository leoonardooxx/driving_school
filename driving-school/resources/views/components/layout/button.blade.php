@props([
    'route' => null,
    'label' => null,
    'icon' => null,
    'theme' => 'black',
    'color' => 'normal',
    'dropdown' => [],
])

@php
    $icon ??= $label ? null : 'lucide-circle-question-mark';
    $themes = [
        'black' =>
            'text-white/90 bg-white/5 border-white/20 hover:bg-white/10 shadow-[inset_0_1px_1px_rgba(255,255,255,0.35),inset_0_-1px_1px_rgba(0,0,0,0.4),0_4px_12px_rgba(0,0,0,0.5)]',
        'white' =>
            'text-black bg-black/5 border-black/10 hover:bg-black/10 shadow-[inset_0_1px_1px_rgba(255,255,255,0.8),inset_0_-1px_1px_rgba(0,0,0,0.1),0_4px_12px_rgba(0,0,0,0.15)]',
    ];
    if ($color === 'school_color') {
        $themes[$theme] = 'text-white bg-school/85 border-white/25 hover:bg-school shadow-[inset_0_1px_1px_rgba(255,255,255,0.45),inset_0_-1px_1px_rgba(0,0,0,0.2),0_4px_12px_rgba(232,90,49,0.35)]';
    }
    $routes = array_map(
        fn ($r) => str_contains($r, '.') ? Str::beforeLast($r, '.') . '.*' : $r,
        array_filter([$route, ...array_column($dropdown, 'route')]),
    );
    $active = $routes && request()->routeIs(...$routes);
    $dropdownId = 'dropdown-' . uniqid();
    $activeThemes = [
        'black' => 'bg-white text-black border-white',
        'white' => 'bg-black text-white border-black',
    ];
    if ($color === 'school_color') {
        $activeThemes[$theme] = 'bg-school text-white border-school ring-2 ring-school/30';
    }
    $classes =
        'h-11 flex justify-center items-center gap-2 rounded-full backdrop-blur-md border transition ' .
        ($label ? 'px-4 ' : 'w-11 ') .
        ($active ? $activeThemes[$theme] : $themes[$theme]);
@endphp

@if ($route && ! $dropdown)
    <a href="{{ route($route) }}" @if ($active) aria-current="page" @endif {{ $attributes->merge(['class' => $classes]) }}>
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @else
            @if ($icon)
                <x-dynamic-component :component="$icon" class="w-5 h-5" />
            @endif
            @if ($label)
                <span>{{ $label }}</span>
            @endif
        @endif
    </a>
@else
    <button type="button" @if ($dropdown) popovertarget="{{ $dropdownId }}" style="anchor-name: --{{ $dropdownId }}" @endif {{ $attributes->merge(['class' => $classes]) }}>
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @else
            @if ($icon)
                <x-dynamic-component :component="$icon" class="w-5 h-5" />
            @endif
            @if ($label)
                <span>{{ $label }}</span>
            @endif
            @if ($dropdown)
                <x-lucide-chevron-down class="size-4 opacity-60" />
            @endif
        @endif
    </button>
    @if ($dropdown)
        <x-container :theme="$active ? ($theme === 'white' ? 'black' : 'white') : $theme" id="{{ $dropdownId }}" popover="auto" style="position-anchor: --{{ $dropdownId }}; position-area: bottom span-right;" @class(['inset-auto m-0 mt-2 p-1! rounded-2xl! text-sm min-w-44', $theme === 'white' ? 'bg-black! text-white! border-black!' : 'bg-white! text-black! border-white!' => $active])>
            @foreach ($dropdown as $item)
                <a href="{{ route($item['route']) }}" @if (request()->routeIs($item['route'])) aria-current="page" @endif class="flex items-center gap-2 px-2.5 py-1.5 rounded-xl opacity-70 hover:opacity-100 hover:bg-current/5 aria-[current=page]:opacity-100 aria-[current=page]:font-medium">
                    @isset($item['icon'])
                        <x-dynamic-component :component="$item['icon']" class="size-4" />
                    @endisset
                    {{ $item['label'] }}
                </a>
            @endforeach
        </x-container>
    @endif
@endif
