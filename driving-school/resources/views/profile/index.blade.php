@extends('layouts.auth')

@section('content')
<div class="flex-1 flex flex-col gap-3">
    <div class="text-[24px] min-h-11 flex items-center">
        Profile
    </div>

    <div class="flex flex-col lg:flex-row items-start gap-3">
        {{-- Summary: picking a picture uploads it straight away --}}
        <x-container theme="white" class="w-full lg:w-96 shrink-0">
            <div class="flex flex-col items-center text-center gap-3 pt-4 pb-5">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="flex" onchange="this.requestSubmit()">
                    @csrf
                    @method('PUT')
                    <x-avatar-input name="image" :value="$user->image_url" size="size-28" :initial="Str::upper(Str::substr($user->name, 0, 1))" />
                </form>
                @error('image')
                    <div class="text-sm text-red-500">{{ $message }}</div>
                @enderror
                <div class="max-w-full">
                    <div class="text-xl truncate">{{ $user->name }} {{ $user->last_name }}</div>
                    <div class="text-sm opacity-60 truncate">{{ '@' . $user->username }}</div>
                </div>
                <div class="flex gap-2 text-xs">
                    <span class="px-3 py-1 rounded-full bg-school/10 text-school border border-school/20">{{ ucfirst($user->profile) }}</span>
                    <span class="px-3 py-1 rounded-full bg-black/5 border border-black/10 flex items-center gap-1.5">
                        <span @class(['size-1.5 rounded-full', 'bg-green-600' => $user->active, 'bg-current/40' => ! $user->active])></span>
                        {{ $user->active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="border-t border-current/10 text-sm px-1">
                @foreach ([
                    ['lucide-mail', 'Email', $user->email],
                    ['lucide-id-card', 'NIF', $user->nif],
                    ['lucide-calendar', 'Member since', $user->created_at?->format('d/m/Y') ?? '-'],
                ] as [$icon, $label, $value])
                    <div class="flex items-center gap-3 py-3 border-b border-current/10 last:border-0">
                        <x-dynamic-component :component="$icon" class="size-4 opacity-60 shrink-0" />
                        <span class="opacity-60 whitespace-nowrap">{{ $label }}</span>
                        <span class="ml-auto text-right truncate">{{ $value }}</span>
                    </div>
                @endforeach
            </div>
        </x-container>

        <div class="flex-1 min-w-0 w-full flex flex-col gap-3">
            <x-container theme="white">
                <form action="{{ route('profile.update') }}" method="POST" class="flex flex-col gap-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <div class="text-lg">Personal information</div>
                        <div class="text-sm opacity-60">Update your name and contact details.</div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <x-input name="name" label="Name" theme="light" :value="$user->name" />
                        <x-input name="last_name" label="Surname" theme="light" :value="$user->last_name" />
                        <x-input type="email" name="email" label="Email" theme="light" :value="$user->email" />
                        <x-input name="nif" label="NIF" theme="light" :value="$user->nif" />
                    </div>

                    @if ($errors->hasAny(['name', 'last_name', 'email', 'nif']))
                        <ul class="text-sm text-red-500">
                            @foreach (['name', 'last_name', 'email', 'nif'] as $field)
                                @foreach ($errors->get($field) as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    @endif

                    <div class="flex justify-end items-center gap-4">
                        @if (session('status') === 'profile-updated')
                            <span class="text-sm text-green-700 flex items-center gap-1.5"><x-lucide-check class="size-4" /> Saved</span>
                        @endif
                        <x-button type="submit" theme="white">Save changes</x-button>
                    </div>
                </form>
            </x-container>

            <x-container theme="white">
                <form action="{{ route('profile.password') }}" method="POST" class="flex flex-col gap-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <div class="text-lg">Password</div>
                        <div class="text-sm opacity-60">Use at least 8 characters.</div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <x-input type="password" name="current_password" label="Current password" theme="light" />
                        <x-input type="password" name="password" label="New password" theme="light" />
                        <x-input type="password" name="password_confirmation" label="Confirm password" theme="light" />
                    </div>

                    @if ($errors->hasAny(['current_password', 'password']))
                        <ul class="text-sm text-red-500">
                            @foreach (['current_password', 'password'] as $field)
                                @foreach ($errors->get($field) as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    @endif

                    <div class="flex justify-end items-center gap-4">
                        @if (session('status') === 'password-updated')
                            <span class="text-sm text-green-700 flex items-center gap-1.5"><x-lucide-check class="size-4" /> Password updated</span>
                        @endif
                        <x-button type="submit" theme="white">Update password</x-button>
                    </div>
                </form>
            </x-container>
        </div>
    </div>
</div>
@endsection
