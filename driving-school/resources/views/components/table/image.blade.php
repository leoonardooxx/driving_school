@props([
    'value' => null,
])

@if ($value)
    <img src="{{ Storage::url($value) }}" alt="" class="block size-14 -my-4 object-cover">
@else
    <div class="size-14 -my-4 bg-current/10"></div>
@endif
