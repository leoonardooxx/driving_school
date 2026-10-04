@extends('layouts.app')
@php
$nav = [
    ['label' => 'Pre-registration', 'route' => 'dashboard'],
]
@endphp
@section('body')
<div class="flex flex-col gap-7 min-h-full">
    <x-layout.navbar :nav="$nav" :showAll="false" :loggedInOptions="false"/>
    <div class="flex-1 flex flex-col">
        @yield('content')
    </div>
</div>

@endsection
