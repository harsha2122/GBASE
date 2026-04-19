@extends('layouts.admin')

@section('title', 'Create Page')

@section('content')
<h1>Create New Page</h1>
<form method="POST" action="{{ route('pages.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">Page Title</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" required>
        <small>URL slug (e.g., 'home', 'equipments')</small>
    </div>
    <div class="mb-3">
        <label class="form-label">Meta Description</label>
        <input type="text" name="meta_description" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" class="form-control" rows="5"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Breadcrumb</label>
        <input type="text" name="breadcrumb" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Hero Image</label>
        <input type="file" name="hero_image" class="form-control" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Create Page</button>
    <a href="{{ route('pages.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
