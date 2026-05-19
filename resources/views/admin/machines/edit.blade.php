@extends('layouts.admin')

@section('title', 'Edit Machine')
@section('page_title', 'Edit Machine: ' . $machine->name)

@section('content')
<form method="POST" action="{{ route('machines.update', $machine) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.machines.form')
</form>
@endsection
