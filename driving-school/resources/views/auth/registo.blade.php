@extends('layouts.app')

@section('body')
    <form action="{{ url('register') }}" method="POST" class="gap-4 flex flex-col">
        @csrf
        <x-input name="name" label="Nome"/>
        {{-- <input type="text" name="name" placeholder="Name"> --}}
        <x-input type="text" name="last_name" label="Sobrenome"/>
        <x-input type="email" name="email" label="Email"/>
        <x-input type="password" name="password" label="Palavra-passe"/>
        <x-input type="text" name="profile" label="Perfil"/>
        <x-input type="text" name="nif" label="NIF"/>

        <button type="submit">Register</button>
    </form>

    @foreach ($errors->all() as $error)
        <div>
            {{ $error }}
        </div>
    @endforeach
@endsection
