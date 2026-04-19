@extends('layouts.admin')

@section('title', 'Edit Machine')

@section('content')
<h1>Edit Machine</h1>
<form method="POST" action="{{ route('machines.update', $machine) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Machine Name</label>
        <input type="text" name="name" class="form-control" value="{{ $machine->name }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <input type="text" name="category" class="form-control" value="{{ $machine->category }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ $machine->slug }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4">{{ $machine->description }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Image</label>
        @if ($machine->image)
            <div class="mb-2"><img src="{{ asset('storage/' . $machine->image) }}" style="max-width: 200px;"></div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <div class="mb-3">
        <label class="form-label">Page</label>
        <input type="text" name="page" class="form-control" value="{{ $machine->page }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Order</label>
        <input type="number" name="order" class="form-control" value="{{ $machine->order }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
