@props([
    'name' => null,
    'value' => false,
])

<label class="relative inline-flex cursor-pointer items-center has-disabled:cursor-default">
    <input type="checkbox" role="switch" name="{{ $name }}" value="1" @checked($value) {{ $attributes->merge(['class' => 'peer sr-only']) }}>
    <span class="h-6 w-11 rounded-full bg-current/15 transition-colors peer-checked:bg-school peer-focus-visible:ring-2 peer-focus-visible:ring-school/50"></span>
    <span class="absolute left-0.5 size-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></span>
</label>
