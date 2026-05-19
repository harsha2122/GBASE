@extends('layouts.admin')

@section('title', 'Create Page')
@section('page_title', 'Create New Page')

@section('content')
<form method="POST" action="{{ route('pages.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.pages.form')
</form>
@endsection
