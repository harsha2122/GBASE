@extends('layouts.admin')

@section('title', 'Edit Contact')
@section('page_title', 'Edit Contact: ' . $contact->type)

@section('content')
<form method="POST" action="{{ route('contact-details.update', $contact) }}">
    @csrf
    @method('PUT')
    @include('admin.contact-details.form')
</form>
@endsection
