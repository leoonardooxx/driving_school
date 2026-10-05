@props([
    'name' => 'image',
    'value' => null,
    'label' => 'Profile picture',
    'size' => 'size-20',
    'initial' => null,
])

{{--
    value   = stored path (users/abc.jpg) or a ready URL (/users/1/avatar)
    size    = Tailwind size class of the circle
    initial = letter shown while there is no picture (instead of the camera icon)
--}}

<label @class([
    'group/avatar relative shrink-0 rounded-full overflow-hidden cursor-pointer border-2 transition flex items-center justify-center',
    $size,
    'bg-black/5 hover:bg-black/10' => ! $initial,
    'bg-school text-white text-4xl font-bold' => $initial,
    'border-black/10' => ! $errors->has($name),
    'border-red-500 animate-shake' => $errors->has($name),
]) aria-label="{{ $label }}">
    <input
        type="file"
        name="{{ $name }}"
        accept="image/*"
        class="sr-only"
        onchange="
            const file = this.files[0];
            const img = this.parentElement.querySelector('img');
            if (! file) return img.removeAttribute('src');
            const reader = new FileReader();
            reader.onload = () => img.src = reader.result;
            reader.readAsDataURL(file);
        "
        {{ $attributes }}
    >
    @if ($initial)
        {{ $initial }}
    @else
        <x-lucide-camera class="size-7 opacity-50" />
    @endif
    <img @if ($value) src="{{ Str::startsWith($value, ['http://', 'https://', '/']) ? $value : Storage::url($value) }}" @endif alt="" class="absolute inset-0 size-full object-cover [&:not([src])]:hidden">
    @if ($initial)
        <div class="absolute bottom-0 inset-x-0 h-9 flex items-center justify-center bg-black/40 text-white group-hover/avatar:bg-black/60 transition">
            <x-lucide-camera class="size-4" />
        </div>
    @else
        <div class="absolute inset-0 flex items-center justify-center bg-black/40 text-white opacity-0 group-hover/avatar:opacity-100 transition">
            <x-lucide-camera class="size-6" />
        </div>
    @endif
</label>
