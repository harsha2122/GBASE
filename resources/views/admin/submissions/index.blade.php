@extends('layouts.admin')

@section('title', 'Submissions')
@section('page_title', 'Contact Form Submissions')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h2 class="text-3xl font-bold text-gray-800">Form Submissions</h2>
        <p class="text-gray-600 mt-1">Manage contact form submissions and respond to inquiries</p>
    </div>

    <!-- Filter -->
    <div class="admin-card">
        <form method="GET" action="{{ route('submissions.index') }}" class="flex gap-4">
            <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}" class="admin-form-input flex-1">
            <select name="status" class="admin-form-select w-48">
                <option value="">All Status</option>
                <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
                <option value="spam" {{ request('status') === 'spam' ? 'selected' : '' }}>Spam</option>
            </select>
            <button type="submit" class="admin-btn-primary">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"/></svg>
            </button>
        </form>
    </div>

    <!-- Submissions Table -->
    <div class="admin-card overflow-x-auto">
        @if($submissions && $submissions->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $submission)
                        <tr>
                            <td class="font-medium text-gray-900">{{ $submission->name }}</td>
                            <td class="text-gray-600">{{ $submission->email }}</td>
                            <td class="text-gray-600">{{ Str::limit($submission->subject, 40) }}</td>
                            <td class="text-gray-600 text-sm">{{ $submission->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($submission->status === 'new')
                                    <span class="badge-warning">New</span>
                                @elseif($submission->status === 'replied')
                                    <span class="badge-success">Replied</span>
                                @else
                                    <span class="badge-danger">Spam</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-3">
                                    <a href="{{ route('submissions.show', $submission) }}" class="text-blue-600 hover:text-blue-700 font-medium">View</a>
                                    <form method="POST" action="{{ route('submissions.destroy', $submission) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
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
            @if($submissions->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $submissions->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6m0 0h6"/></svg>
                <p class="text-gray-500 text-lg">No submissions found</p>
            </div>
        @endif
    </div>
</div>
@endsection
