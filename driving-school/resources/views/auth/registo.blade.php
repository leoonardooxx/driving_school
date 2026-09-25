@extends('layouts.app')

@section('body')
    <form action="{{ url('register') }}" method="POST" class="gap-4 flex flex-col">
        @csrf
        <x-input name="name" label="Nome" theme="light" />
        {{-- <input type="text" name="name" placeholder="Name"> --}}
        <x-input type="text" name="last_name" label="Sobrenome" theme="light" />
        <x-input type="email" name="email" label="Email" theme="light" />
        <x-input type="password" name="password" label="Palavra-passe" theme="light" />
        <x-input type="text" name="profile" label="Perfil" theme="light" />
        <x-input type="text" name="nif" label="NIF" theme="light" />

        <x-button type="submit">Register</x-button>
    </form>

    @foreach ($errors->all() as $error)
        <div>
            {{ $error }}
        </div>
    @endforeach
@endsection
