@extends('layouts.app')

@section('body')
<div class="flex flex-col gap-7">
    <x-layout.navbar />
    <div>
        @yield('content')
    </div>

</div>

@endsection
