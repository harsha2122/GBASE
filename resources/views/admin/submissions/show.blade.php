@extends('layouts.admin')

@section('title', 'View Submission')
@section('page_title', 'Submission from ' . $submission->name)

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <a href="{{ route('submissions.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.707 9.293a1 1 0 010 1.414L5.414 13H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"/></svg>
        Back to Submissions
    </a>

    <!-- Submission Details -->
    <div class="admin-card">
        <div class="grid grid-cols-2 gap-6 mb-6 pb-6 border-b border-gray-200">
            <div>
                <p class="text-gray-600 text-sm">Name</p>
                <p class="text-lg font-semibold text-gray-900">{{ $submission->name }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Email</p>
                <p class="text-lg font-semibold text-gray-900">{{ $submission->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Phone</p>
                <p class="text-lg font-semibold text-gray-900">{{ $submission->phone ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Status</p>
                <p class="mt-2">
                    @if($submission->status === 'new')
                        <span class="badge-warning">New</span>
                    @elseif($submission->status === 'replied')
                        <span class="badge-success">Replied</span>
                    @else
                        <span class="badge-danger">Spam</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="mb-6 pb-6 border-b border-gray-200">
            <p class="text-gray-600 text-sm font-semibold mb-2">Subject</p>
            <p class="text-gray-900">{{ $submission->subject }}</p>
        </div>

        <div>
            <p class="text-gray-600 text-sm font-semibold mb-2">Message</p>
            <div class="bg-gray-50 p-4 rounded-lg text-gray-900 whitespace-pre-wrap">{{ $submission->message }}</div>
            <p class="text-gray-500 text-xs mt-2">Submitted on {{ $submission->created_at->format('M d, Y h:i A') }}</p>
        </div>
    </div>

    <!-- Replies -->
    @if($submission->replies->count() > 0)
        <div class="admin-card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Replies</h3>
            <div class="space-y-4">
                @foreach($submission->replies as $reply)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <p class="font-semibold text-blue-900">Admin Reply</p>
                            <p class="text-blue-700 text-xs">{{ $reply->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="text-blue-900 whitespace-pre-wrap">{{ $reply->message }}</div>
                        @if($reply->sent_email)
                            <p class="text-xs text-green-600 mt-2">✓ Email sent to user</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Reply Form -->
    <div class="admin-card">
        <h3 class="text-lg font-bold text-gray-800 mb-6">{{ $submission->replies->count() > 0 ? 'Send Another Reply' : 'Send Reply' }}</h3>

        <form method="POST" action="{{ route('submissions.reply', $submission) }}">
            @csrf

            <div class="admin-form-group">
                <label class="admin-form-label">Your Reply *</label>
                <textarea name="message" required class="admin-form-textarea" rows="6" placeholder="Type your reply here..."></textarea>
            </div>

            <div class="admin-form-group">
                <label class="flex items-center">
                    <input type="checkbox" name="send_email" checked class="mr-3">
                    <span class="text-gray-700">Send this reply as email to user</span>
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="admin-btn-primary">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                        Send Reply
                    </span>
                </button>
                <a href="{{ route('submissions.index') }}" class="admin-btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
