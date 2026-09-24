@props([
    'type' => 'text',
    'label' => 'Example',
    'name' => 'example',
])

<div class="relative border-b">
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder=" "
        class="
            peer
            w-full
            px-0
            pt-4
            pb-1
            text-base
            outline-none
            border-none
            bg-transparent

            autofill:bg-white
            autofill:text-black
            autofill:shadow-[inset_0_0_0px_1000px_white]

            transition-[background-color,color]
            duration-[5000s]
        "
    >

    <label
        for="{{ $name }}"
        class="
            absolute
            left-0
            top-1/2
            -translate-y-1/2

            text-base
            text-gray-500
            pointer-events-none
            transition-all
            duration-200

            peer-focus:top-0
            peer-focus:text-xs
            peer-focus:-translate-y-1/2
            peer-focus:text-blue-500

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
