@extends('layouts.auth')

@section('content')
<x-resource-page title="Users" route="users" :header="$header" :body="$users" :form="$form" create-title="Add an user" edit-title="Edit user" details-title="User details" />
@endsection
