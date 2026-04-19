@extends('layouts.admin')

@section('title', 'Cards')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1>Service Cards</h1>
    <a href="{{ route('cards.create') }}" class="btn btn-primary">+ New Card</a>
</div>

<table class="table table-striped">
    <thead><tr><th>Title</th><th>Page</th><th>Order</th><th>Actions</th></tr></thead>
    <tbody>
        @foreach ($cards as $card)
            <tr>
                <td>{{ $card->title }}</td>
                <td>{{ $card->page }}</td>
                <td>{{ $card->order }}</td>
                <td>
                    <a href="{{ route('cards.edit', $card) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('cards.destroy', $card) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
