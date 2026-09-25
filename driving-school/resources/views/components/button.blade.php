@props([
    'type' => 'button'
])
<button type="{{ $type }}" class="bg-[#e85a31] text-white rounded-full py-3">
    {{ $slot }}
</button>
