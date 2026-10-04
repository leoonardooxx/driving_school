@extends('layouts.auth')

@section('content')
<x-resource-page title="Categories" route="categories" :header="$header" :body="$categories" :form="$form" create-title="Add a category" edit-title="Edit category" details-title="Category details" />
@endsection
