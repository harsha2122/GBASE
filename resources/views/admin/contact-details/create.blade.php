@extends('layouts.admin')

@section('title', 'Add Contact')
@section('page_title', 'Add Contact Detail')

@section('content')
<form method="POST" action="{{ route('contact-details.store') }}">
    @csrf
    @include('admin.contact-details.form')
</form>
@endsection
