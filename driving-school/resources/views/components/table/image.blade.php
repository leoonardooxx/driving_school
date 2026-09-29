@props([
    'value' => null,
    'rounded' => false,
])

@if ($value)
    <img src="{{ Str::startsWith($value, ['http://', 'https://', '/']) ? $value : Storage::url($value) }}" alt="" @class(['block size-14 -my-4 object-cover', 'rounded-full' => $rounded])>
@else
    <div @class(['size-14 -my-4 bg-current/10', 'rounded-full' => $rounded])></div>
@endif
