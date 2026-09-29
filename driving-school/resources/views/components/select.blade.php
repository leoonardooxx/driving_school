@props([
    'name' => 'example',
    'label' => 'Example',
    'options' => [],
    'value' => null,
    'theme' => 'dark',
])

{{--
    example options =
    [
    'valor' => 'Label',
    ]
--}}

@php
    $selected = (string) old($name, $value);
    $id = 'select-' . uniqid();
@endphp

<div @class([
    'relative border-b',
    '[--fg:white]' => $theme === 'dark',
    '[--fg:black]' => $theme === 'light',
    'border-(--fg)' => ! $errors->has($name),
    'border-red-500 animate-shake' => $errors->has($name),
])>
    <input type="hidden" name="{{ $name }}" value="{{ $selected }}">

    <button type="button" popovertarget="{{ $id }}" style="anchor-name: --{{ $id }}" {{ $attributes->merge(['class' => 'peer group/select w-full flex items-center justify-between gap-2 pt-4 pb-1 text-base text-left text-(--fg) outline-none cursor-pointer']) }}>
        <span data-select-label @class(['min-h-6', 'invisible' => ! array_key_exists($selected, $options)])>{{ $options[$selected] ?? '' }}</span>
        <x-lucide-chevron-down class="size-4 opacity-60" />
    </button>

    <label @class([
        'absolute left-0 pointer-events-none transition-all duration-200',
        'top-0 text-xs -translate-y-1/2' => array_key_exists($selected, $options),
        'top-1/2 -translate-y-1/2 text-base' => ! array_key_exists($selected, $options),
        'text-red-500' => $errors->has($name),
        'text-(--fg) peer-focus:text-school' => ! $errors->has($name),
    ])>
        {{ $label }}
    </label>

    <x-container :theme="$theme === 'light' ? 'white' : 'black'" id="{{ $id }}" popover="auto" style="position-anchor: --{{ $id }}; position-area: bottom span-right; min-width: anchor-size(width);" @class(['inset-auto m-0 mt-2 p-1! rounded-2xl! text-sm', 'bg-white/95! text-black!' => $theme === 'light', 'bg-neutral-900/95! text-white!' => $theme !== 'light'])>
        @foreach ($options as $optionValue => $optionLabel)
            <button type="button" role="option" value="{{ $optionValue }}" @if ((string) $optionValue === $selected) aria-selected="true" @endif
                onclick="
                    const field = this.closest('[popover]').parentElement;
                    field.querySelector('input[type=hidden]').value = this.value;
                    const label = field.querySelector('[data-select-label]');
                    label.textContent = this.textContent.trim();
                    label.classList.remove('invisible');
                    const floating = field.querySelector('label');
                    floating.classList.remove('top-1/2', 'text-base');
                    floating.classList.add('top-0', 'text-xs');
                    this.parentElement.querySelectorAll('[role=option]').forEach(option => option.removeAttribute('aria-selected'));
                    this.setAttribute('aria-selected', 'true');
                    this.closest('[popover]').hidePopover();
                "
                class="w-full flex items-center gap-2 px-2.5 py-1.5 rounded-xl text-left opacity-80 hover:opacity-100 hover:bg-school/10 hover:text-school aria-selected:opacity-100 aria-selected:font-medium aria-selected:bg-school aria-selected:text-white aria-selected:hover:bg-school aria-selected:hover:text-white cursor-pointer">
                {{ $optionLabel }}
            </button>
        @endforeach
    </x-container>
</div>
