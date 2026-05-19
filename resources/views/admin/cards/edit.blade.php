@extends('layouts.admin')

@section('title', 'Edit Card')
@section('page_title', 'Edit Service Card: ' . $card->title)

@section('content')
<form method="POST" action="{{ route('cards.update', $card) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.cards.form')
</form>
@endsection
