@props([
    'type' => 'text',
    'label' => 'Example',
    'name' => 'example',
    'theme' => 'dark',
])

<div @class([
    'relative border-b',
    '[--fg:white] [--bg:#0F0F10]' => $theme === 'dark',
    '[--fg:black] [--bg:white]' => $theme === 'light',
    'border-(--fg)' => ! $errors->has($name),
    'border-red-500 animate-shake' => $errors->has($name),
])>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder=" "
        @if($type !== 'password') value="{{ old($name) }}" @endif
        readonly
        onpointerdown="this.readOnly = false"
        onfocus="this.readOnly = false"
        class="
            peer
            w-full
            px-0
            {{ $type === 'password' ? 'pr-8' : '' }}
            [[type=password]]:font-[Verdana,sans-serif]
            [[type=password]]:tracking-widest
            pt-4
            pb-1
            text-base
            text-(--fg)
            outline-none
            border-none
            bg-transparent

            autofill:bg-(--bg)
            autofill:text-(--fg)
            autofill:[-webkit-text-fill-color:var(--fg)]
            autofill:shadow-[inset_0_0_0px_1000px_var(--bg)]

            transition-[background-color,color]
            duration-[5000s]
        "
    >
    @if($type === 'password')
        <button
            type="button"
            aria-label="Mostrar palavra-passe"
            class="group absolute right-0 top-1/2 -translate-y-1/2 text-(--fg) cursor-pointer"
            onclick="
                const input = this.parentElement.querySelector('input');
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                this.classList.toggle('is-visible', show);
                this.setAttribute('aria-label', show ? 'Esconder palavra-passe' : 'Mostrar palavra-passe');
            "
        >
            <x-lucide-eye class="size-5 group-[.is-visible]:hidden" />
            <x-lucide-eye-closed class="size-5 hidden group-[.is-visible]:block" />
        </button>
    @endif

    <label
        for="{{ $name }}"
        class="
            absolute
            left-0
            top-1/2
            -translate-y-1/2

            text-base
            {{ $errors->has($name) ? 'text-red-500 peer-focus:text-red-500' : 'text-(--fg) peer-focus:text-[#e85a31]' }}
            pointer-events-none
            transition-all
            duration-200

            peer-focus:top-0
            peer-focus:text-xs
            peer-focus:-translate-y-1/2

            peer-placeholder-shown:top-1/2
            peer-placeholder-shown:text-base

            peer-not-placeholder-shown:top-0
            peer-not-placeholder-shown:text-xs
            peer-not-placeholder-shown:-translate-y-1/2

            peer-autofill:top-0
            peer-autofill:text-xs
            peer-autofill:-translate-y-1/2
        "
    >
        {{ $label }}
    </label>
</div>
