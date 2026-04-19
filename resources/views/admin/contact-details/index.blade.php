@extends('layouts.admin')

@section('title', 'Contact Details')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Contact Details</h1>
    <a href="{{ route('contact-details.create') }}" class="btn btn-primary">+ Add Detail</a>
</div>

<table class="table table-striped">
    <thead><tr><th>Type</th><th>Value</th><th>Icon</th><th>Order</th><th>Actions</th></tr></thead>
    <tbody>
        @foreach ($contacts as $contact)
            <tr>
                <td>{{ $contact->type }}</td>
                <td>{{ $contact->value }}</td>
                <td>{{ $contact->icon ?? '-' }}</td>
                <td>{{ $contact->order }}</td>
                <td>
                    <a href="{{ route('contact-details.edit', $contact) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('contact-details.destroy', $contact) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
