@extends('layouts.admin')

@section('title', 'Submissions')
@section('page_title', 'Contact Form Submissions')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <p class="text-gray-400 text-sm">Manage and respond to contact form submissions</p>
    </div>

    <!-- Filters -->
    <div class="admin-card">
        <form method="GET" action="{{ route('submissions.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="admin-form-label text-xs">Search</label>
                <input type="text" name="search" placeholder="Name or email..." value="{{ request('search') }}" class="admin-form-input">
            </div>
            <div>
                <label class="admin-form-label text-xs">Status</label>
                <select name="status" class="admin-form-select">
                    <option value="">All Status</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                    <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
                    <option value="spam" {{ request('status') === 'spam' ? 'selected' : '' }}>Spam</option>
                </select>
            </div>
            <div class="col-span-2 flex items-end">
                <button type="submit" class="btn-primary w-full">
                    <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"/></svg>
                </button>
            </div>
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
                            <td class="font-semibold text-white">{{ $submission->name }}</td>
                            <td class="text-gray-400">{{ $submission->email }}</td>
                            <td class="text-gray-400">{{ Str::limit($submission->subject, 40) }}</td>
                            <td class="text-gray-500 text-sm">{{ $submission->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($submission->status === 'new')
                                    <span class="badge badge-warning">New</span>
                                @elseif($submission->status === 'replied')
                                    <span class="badge badge-success">Replied</span>
                                @else
                                    <span class="badge badge-danger">Spam</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('submissions.show', $submission) }}" class="text-primary hover:text-secondary font-medium text-sm">View →</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($submissions->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $submissions->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <p class="text-gray-400">No submissions yet</p>
            </div>
        @endif
    </div>
</div>
@endsection
