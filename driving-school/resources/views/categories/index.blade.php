@extends('layouts.auth')

@section('content')
<div class="flex flex-col gap-3">
    <div class="flex justify-between">
        <div class="text-[24px]">
            Categories
        </div>
            <x-layout.button color="school_color" theme="white" icon="lucide-plus" label="Add an category"/>

    </div>
    <x-container theme="white">
        <x-table :header="$header" :body="$categories"/>
    </x-container>
</div>


@endsection
