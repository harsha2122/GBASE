@extends('layouts.admin')

@section('title', 'Create Machine')
@section('page_title', 'Add New Machine')

@section('content')
<form method="POST" action="{{ route('machines.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.machines.form')
</form>
@endsection
