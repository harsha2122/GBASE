@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Statistics Grid -->
    <div class="stat-grid">
        <!-- Pages Card -->
        <div class="gradient-card-primary">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium">Total Pages</p>
                    <p class="text-4xl font-bold mt-2">{{ $total_pages ?? 0 }}</p>
                    <p class="text-indigo-100 text-xs mt-2">Editable content pages</p>
                </div>
                <svg class="w-16 h-16 text-indigo-300 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"/></svg>
            </div>
        </div>

        <!-- Machines Card -->
        <div class="gradient-card-success">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Total Machines</p>
                    <p class="text-4xl font-bold mt-2">{{ $total_machines ?? 0 }}</p>
                    <p class="text-emerald-100 text-xs mt-2">Equipment inventory</p>
                </div>
                <svg class="w-16 h-16 text-emerald-300 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 000-2H7zM4 7a1 1 0 011-1h10a1 1 0 011 1v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"/></svg>
            </div>
        </div>

        <!-- Cards Card -->
        <div class="gradient-card-warning">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm font-medium">Service Cards</p>
                    <p class="text-4xl font-bold mt-2">{{ $total_cards ?? 0 }}</p>
                    <p class="text-amber-100 text-xs mt-2">Feature cards</p>
                </div>
                <svg class="w-16 h-16 text-amber-300 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"/></svg>
            </div>
        </div>

        <!-- Submissions Card -->
        <div class="gradient-card-info">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">New Submissions</p>
                    <p class="text-4xl font-bold mt-2">{{ $total_submissions ?? 0 }}</p>
                    <p class="text-blue-100 text-xs mt-2">Pending responses</p>
                </div>
                <svg class="w-16 h-16 text-blue-300 opacity-50" fill="currentColor" viewBox="0 0 20 20"><path d="M2.5 1A1.5 1.5 0 001 2.5v15A1.5 1.5 0 002.5 19h15a1.5 1.5 0 001.5-1.5v-15A1.5 1.5 0 0017.5 1h-15z"/></svg>
            </div>
        </div>
    </div>

    <!-- Recent Submissions -->
    <div class="admin-card">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-white">Recent Submissions</h3>
                <p class="text-gray-400 text-sm mt-1">Latest contact form submissions</p>
            </div>
            <a href="{{ route('submissions.index') }}" class="btn-primary text-sm">View All →</a>
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
                                <td class="font-semibold text-white">{{ $submission->name }}</td>
                                <td class="text-gray-400">{{ $submission->email }}</td>
                                <td class="text-gray-400">{{ Str::limit($submission->subject, 30) }}</td>
                                <td class="text-gray-500 text-sm">{{ $submission->created_at->format('M d, Y') }}</td>
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
                                    <a href="{{ route('submissions.show', $submission) }}" class="text-primary hover:text-secondary font-medium text-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-gray-400">No submissions yet</p>
            </div>
        @endif
    </div>
</div>
@endsection
