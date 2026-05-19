@extends('layouts.admin')

@section('title', 'Edit Page')
@section('page_title', 'Edit Page: ' . $page->title)

@section('content')
<form method="POST" action="{{ route('pages.update', $page) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.pages.form')
</form>
@endsection
