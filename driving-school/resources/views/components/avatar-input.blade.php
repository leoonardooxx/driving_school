@props([
    'name' => 'image',
    'value' => null,
    'label' => 'Profile picture',
])

<label @class([
    'group/avatar relative size-20 shrink-0 rounded-full overflow-hidden cursor-pointer border-2 bg-black/5 hover:bg-black/10 transition flex items-center justify-center',
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
    <x-lucide-camera class="size-7 opacity-50" />
    <img @if ($value) src="{{ Storage::url($value) }}" @endif alt="" class="absolute inset-0 size-full object-cover [&:not([src])]:hidden">
    <div class="absolute inset-0 flex items-center justify-center bg-black/40 text-white opacity-0 group-hover/avatar:opacity-100 transition">
        <x-lucide-camera class="size-6" />
    </div>
</label>
