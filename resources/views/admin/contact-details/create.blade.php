@extends('layouts.admin')

@section('title', 'Add Contact Detail')

@section('content')
<h1>Add Contact Detail</h1>
<form method="POST" action="{{ route('contact-details.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Type</label>
        <input type="text" name="type" class="form-control" placeholder="e.g., phone, email, whatsapp" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Value</label>
        <input type="text" name="value" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Icon Class</label>
        <input type="text" name="icon" class="form-control" placeholder="e.g., fa-solid fa-phone">
    </div>
    <div class="mb-3">
        <label class="form-label">Order</label>
        <input type="number" name="order" class="form-control" value="0">
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
</form>
@endsection
