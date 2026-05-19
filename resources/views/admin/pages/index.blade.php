@extends('layouts.admin')

@section('title', 'Pages')
@section('page_title', 'Manage Pages')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Pages</h2>
            <p class="text-gray-600 mt-1">Create and manage your website pages</p>
        </div>
        <a href="{{ route('pages.create') }}" class="admin-btn-primary">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
                New Page
            </span>
        </a>
    </div>

    <!-- Search -->
    <div class="admin-card">
        <form method="GET" action="{{ route('pages.index') }}" class="flex gap-4">
            <input type="text" name="search" placeholder="Search pages..." value="{{ request('search') }}" class="admin-form-input flex-1">
            <button type="submit" class="admin-btn-primary">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"/></svg>
            </button>
        </form>
    </div>

    <!-- Pages Table -->
    <div class="admin-card overflow-x-auto">
        @if($pages && $pages->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td class="font-medium text-gray-900">{{ $page->title }}</td>
                            <td class="text-gray-600 font-mono text-sm">{{ $page->slug }}</td>
                            <td>
                                <span class="badge-success">Published</span>
                            </td>
                            <td class="text-gray-600 text-sm">{{ $page->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="flex gap-3">
                                    <a href="{{ route('pages.edit', $page) }}" class="text-blue-600 hover:text-blue-700 font-medium">Edit</a>
                                    <form method="POST" action="{{ route('pages.destroy', $page) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            @if($pages->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $pages->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6m0 0h6"/></svg>
                <p class="text-gray-500 text-lg">No pages found</p>
                <a href="{{ route('pages.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Create your first page</a>
            </div>
        @endif
    </div>
</div>
@endsection
