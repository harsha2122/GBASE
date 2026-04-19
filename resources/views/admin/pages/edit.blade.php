@extends('layouts.admin')

@section('title', 'Edit Page')

@section('content')
<h1>Edit Page: {{ $page->title }}</h1>
<form method="POST" action="{{ route('pages.update', $page) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Page Title</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $page->title }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ $page->slug }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Meta Description</label>
        <input type="text" name="meta_description" class="form-control" value="{{ $page->meta_description }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" class="form-control" rows="5">{{ $page->content }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Breadcrumb</label>
        <input type="text" name="breadcrumb" class="form-control" value="{{ $page->breadcrumb }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Hero Image</label>
        @if ($page->hero_image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $page->hero_image) }}" style="max-width: 200px;">
            </div>
        @endif
        <input type="file" name="hero_image" class="form-control" accept="image/*">
    </div>
    <button type="submit" class="btn btn-primary">Update Page</button>
    <a href="{{ route('pages.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
