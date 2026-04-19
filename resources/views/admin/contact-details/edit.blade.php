@extends('layouts.admin')

@section('title', 'Edit Contact Detail')

@section('content')
<h1>Edit Contact Detail</h1>
<form method="POST" action="{{ route('contact-details.update', $contact) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Type</label>
        <input type="text" name="type" class="form-control" value="{{ $contact->type }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Value</label>
        <input type="text" name="value" class="form-control" value="{{ $contact->value }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Icon Class</label>
        <input type="text" name="icon" class="form-control" value="{{ $contact->icon }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Order</label>
        <input type="number" name="order" class="form-control" value="{{ $contact->order }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
