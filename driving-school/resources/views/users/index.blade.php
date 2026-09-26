@extends('layouts.auth')

@section('content')
<div class="flex flex-col gap-3">
    <div class="flex justify-between items-center">
        <div class="text-[24px]">
            Users
        </div>
            <x-layout.button color="school_color" theme="white" icon="lucide-plus" label="Add an user"/>

    </div>
    <x-container theme="white">
        <x-table :header="$header" :body="$users"/>
    </x-container>
    {{ $users->links() }}
</div>


@endsection
