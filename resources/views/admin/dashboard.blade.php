@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pages Card -->
        <div class="admin-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Pages</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $total_pages ?? 0 }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"/></svg>
                </div>
            </div>
        </div>

        <!-- Machines Card -->
        <div class="admin-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Machines</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $total_machines ?? 0 }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 000-2H7zM4 7a1 1 0 011-1h10a1 1 0 011 1v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"/></svg>
                </div>
            </div>
        </div>

        <!-- Cards Card -->
        <div class="admin-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Service Cards</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $total_cards ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"/></svg>
                </div>
            </div>
        </div>

        <!-- Submissions Card -->
        <div class="admin-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">New Submissions</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $total_submissions ?? 0 }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2.5 1A1.5 1.5 0 001 2.5v15A1.5 1.5 0 002.5 19h15a1.5 1.5 0 001.5-1.5v-15A1.5 1.5 0 0017.5 1h-15z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Submissions -->
    <div class="admin-card">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800">Recent Submissions</h3>
            <a href="{{ route('submissions.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All →</a>
        </div>

        @if($recent_submissions && $recent_submissions->count() > 0)
            <div class="overflow-x-auto">
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
                        @foreach($recent_submissions as $submission)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $submission->name }}</td>
                                <td class="text-gray-600">{{ $submission->email }}</td>
                                <td class="text-gray-600">{{ Str::limit($submission->subject, 30) }}</td>
                                <td class="text-gray-600 text-sm">{{ $submission->created_at->format('M d, Y') }}</td>
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
                                    <a href="{{ route('submissions.show', $submission) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">No submissions yet</p>
            </div>
        @endif
    </div>
</div>
@endsection
