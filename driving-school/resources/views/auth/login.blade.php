@extends('layouts.app')

@section('body')
    {{-- action="{{ url('register') }}" --}}
    <main class="flex w-full h-full">
        <img src="{{ asset('carro_login.png') }}" alt="{{ __('') }}" class="w-1/2 grow object-contain rounded-2xl lg:block hidden"  />

        <div class="w-full h-full bg-[#0F0F10] rounded-2xl flex flex-col py-10">

            {{-- Logo no topo --}}
            <div class="flex justify-center ">
                <img
                    src="{{ asset('logo_branca.png') }}"
                    alt=""
                    class="w-25"
                />
            </div>

            {{-- Formulário centrado --}}
            <div class="flex-1 flex justify-center items-center">
                <form method="POST" action="{{ route('auth.login') }}" class="w-full flex justify-center">
                    @csrf

                    <div class="flex flex-col w-full max-w-100 gap-8">
                        <x-input name="email" label="Email" />
                        <x-input type="password" name="password" label="Palavra-passe" />
                        <x-button type="submit">Entrar</x-button>
                    </div>
                </form>
            </div>

            @foreach ($errors->all() as $error)
                <div>
                    {{ $error }}
                </div>
            @endforeach

        </div>

    </main>
@endsection
