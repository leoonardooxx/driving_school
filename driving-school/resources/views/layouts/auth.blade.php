@extends('layouts.app')
@php
$nav = [['label' => 'Dashboard', 'icon' => 'lucide-layout-dashboard', 'route' => 'dashboard'],
...collect(config('navigation.resources'))->map(fn ($m) => [
'label' => $m[0],
'icon' => $m[2],
'route' => " $m[1].index", 'dropdown'=> [
['label' => 'See all', 'route' => "$m[1].index", 'icon' => 'lucide-eye'],
['label' => "New $m[3]", 'route' => "$m[1].create", 'icon' => 'lucide-plus'],
],
]
),
]
@endphp
@section('body')
<div class="flex flex-col gap-7 min-h-full">
    <x-layout.navbar :nav="$nav" :loggedInOptions="true" />
    <div class="flex-1 flex flex-col">
        @yield('content')
    </div>

</div>

@endsection
