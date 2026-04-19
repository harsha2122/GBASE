@extends('layouts.admin')

@section('title', 'Create Machine')

@section('content')
<h1>Create Machine</h1>
<form method="POST" action="{{ route('machines.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Machine Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <input type="text" name="category" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <div class="mb-3">
        <label class="form-label">Page</label>
        <input type="text" name="page" class="form-control" placeholder="e.g., equipments">
    </div>
    <div class="mb-3">
        <label class="form-label">Order</label>
        <input type="number" name="order" class="form-control" value="0">
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection
