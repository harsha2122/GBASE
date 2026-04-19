@extends('layouts.admin')

@section('title', 'Machines')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Machines/Equipment</h1>
    <a href="{{ route('machines.create') }}" class="btn btn-primary">+ New Machine</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Page</th>
            <th>Order</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($machines as $machine)
            <tr>
                <td>{{ $machine->name }}</td>
                <td>{{ $machine->category }}</td>
                <td>{{ $machine->page }}</td>
                <td>{{ $machine->order }}</td>
                <td>
                    <a href="{{ route('machines.edit', $machine) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('machines.destroy', $machine) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
