@extends('layouts.app')

@section('body')
<div class="flex flex-col gap-7 min-h-full">
    <x-layout.navbar />
    <div class="flex-1 flex flex-col">
        @yield('content')
    </div>

</div>

@endsection
