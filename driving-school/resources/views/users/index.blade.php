@extends('layouts.auth')

@section('content')
<div id="users-page" @if ($errors->any()) data-open @endif class="group grid grid-cols-[minmax(0,1fr)_auto] grid-rows-[auto_1fr] gap-3">
    <div class="text-[24px] self-center">
        Users
    </div>
    <x-layout.button color="school_color" theme="white" icon="lucide-plus" label="Add an user" class="group-data-open:hidden" onclick="document.getElementById('users-page').toggleAttribute('data-open', true)" />

    <div class="col-span-2 group-data-open:col-span-1 flex flex-col gap-3 min-w-0">
        <x-container theme="white">
            <x-table :header="$header" :body="$users" />
        </x-container>
        {{ $users->links() }}
    </div>

    <x-container theme="white" class="hidden group-data-open:block col-start-2 row-start-1 row-span-2 self-start w-md">
        <form action="{{ route('users.store') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <div class="flex justify-between items-center">
                <div class="text-lg">Add an user</div>
                <button type="button" onclick="document.getElementById('users-page').toggleAttribute('data-open', false)" aria-label="Fechar" class="cursor-pointer opacity-60 hover:opacity-100">
                    <x-lucide-x class="size-5" />
                </button>
            </div>

            <x-input name="name" label="Name" theme="light" />
            <x-input name="last_name" label="Surname" theme="light" />
            <x-input type="email" name="email" label="Email" theme="light" />
            <x-input name="nif" label="NIF" theme="light" />
            <x-input type="password" name="password" label="Password" theme="light" />
            <x-input type="password" name="password_confirmation" label="Confirm password" theme="light" />

            <select name="profile" @class(['border-b bg-transparent pt-4 pb-1 outline-none', 'border-black' => ! $errors->has('profile'), 'border-red-500' => $errors->has('profile')])>
                @foreach (['student' => 'Student', 'instructor' => 'Instructor', 'admin' => 'Admin'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('profile') === $value)>{{ $label }}</option>
                @endforeach
            </select>

            <div class="flex items-center gap-3">
                <x-switch name="active" :value="$errors->any() ? old('active') : true" />
                <span>Active</span>
            </div>

            @if ($errors->any())
                <ul class="text-sm text-red-500">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <x-button type="submit" theme="white">Create</x-button>
        </form>
    </x-container>
</div>
@endsection
