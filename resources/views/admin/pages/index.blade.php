@extends('layouts.admin')

@section('title', 'Pages')
@section('page_title', 'Pages Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-400 text-sm">Manage all website pages and content</p>
        </div>
        <a href="{{ route('pages.create') }}" class="btn-primary flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
            Add New Page
        </a>
    </div>

    <!-- Search -->
    <div class="admin-card">
        <form method="GET" action="{{ route('pages.index') }}" class="flex gap-3">
            <input type="text" name="search" placeholder="Search pages by title or slug..." value="{{ request('search') }}" class="admin-form-input flex-1">
            <button type="submit" class="btn-primary">
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
                        <th>Slug (URL)</th>
                        <th>Breadcrumb</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>
                                <div class="font-semibold text-white">{{ $page->title }}</div>
                                <p class="text-gray-400 text-xs mt-1">{{ Str::limit($page->meta_description, 50) }}</p>
                            </td>
                            <td>
                                <code class="bg-darker px-2 py-1 rounded text-primary text-sm">/{{ $page->slug }}</code>
                            </td>
                            <td class="text-gray-400 text-sm">{{ $page->breadcrumb }}</td>
                            <td class="text-gray-500 text-sm">{{ $page->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('pages.edit', $page) }}" class="text-primary hover:text-secondary font-medium text-sm">Edit</a>
                                    <form method="POST" action="{{ route('pages.destroy', $page) }}" style="display: inline;" onsubmit="return confirm('Delete this page?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 font-medium text-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($pages->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $pages->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                <p class="text-gray-400 text-lg">No pages found</p>
                <a href="{{ route('pages.create') }}" class="text-primary hover:text-secondary mt-4 inline-block">Create your first page →</a>
            </div>
        @endif
    </div>
</div>
@endsection
