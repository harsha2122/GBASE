@extends('layouts.admin')

@section('title', 'Pages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Pages</h1>
    <a href="{{ route('pages.create') }}" class="btn btn-primary">+ New Page</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Slug</th>
            <th>Breadcrumb</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pages as $page)
            <tr>
                <td>{{ $page->title }}</td>
                <td><code>{{ $page->slug }}</code></td>
                <td>{{ $page->breadcrumb ?? '-' }}</td>
                <td>
                    <a href="{{ route('pages.edit', $page) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('pages.destroy', $page) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
