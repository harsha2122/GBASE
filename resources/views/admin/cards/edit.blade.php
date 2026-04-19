@extends('layouts.admin')

@section('title', 'Edit Card')

@section('content')
<h1>Edit Card</h1>
<form method="POST" action="{{ route('cards.update', $card) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ $card->title }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ $card->description }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Icon</label>
        <input type="text" name="icon" class="form-control" value="{{ $card->icon }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Image</label>
        @if ($card->image)<div class="mb-2"><img src="{{ asset('storage/' . $card->image) }}" style="max-width: 200px;"></div>@endif
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <div class="mb-3">
        <label class="form-label">Page</label>
        <input type="text" name="page" class="form-control" value="{{ $card->page }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Order</label>
        <input type="number" name="order" class="form-control" value="{{ $card->order }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
