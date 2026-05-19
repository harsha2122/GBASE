@extends('layouts.admin')

@section('title', 'Create Card')
@section('page_title', 'Create New Service Card')

@section('content')
<form method="POST" action="{{ route('cards.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.cards.form')
</form>
@endsection
