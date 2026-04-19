@extends('layouts.admin')

@section('title', 'Create Card')

@section('content')
<h1>Create Card</h1>
<form method="POST" action="{{ route('cards.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Icon Class</label>
        <input type="text" name="icon" class="form-control" placeholder="e.g., fa-solid fa-box">
    </div>
    <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <div class="mb-3">
        <label class="form-label">Page</label>
        <input type="text" name="page" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Order</label>
        <input type="number" name="order" class="form-control" value="0">
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection
