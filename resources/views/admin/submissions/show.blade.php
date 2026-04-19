@extends('layouts.admin')

@section('title', 'Submission Details')

@section('content')
<h1>Submission Details</h1>

<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">From: {{ $submission->name }}</h5>
        <p><strong>Email:</strong> <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a></p>
        <p><strong>Phone:</strong> {{ $submission->phone ?? '-' }}</p>
        <p><strong>Subject:</strong> {{ $submission->subject ?? '-' }}</p>
        <p><strong>Status:</strong> <span class="badge bg-{{ $submission->status === 'new' ? 'danger' : 'success' }}">{{ ucfirst($submission->status) }}</span></p>
        <p><strong>Date:</strong> {{ $submission->created_at->format('Y-m-d H:i:s') }}</p>
        <hr>
        <h6>Message:</h6>
        <p>{{ nl2br($submission->message) }}</p>
    </div>
</div>

@if ($submission->replies->count())
    <h3>Replies</h3>
    @foreach ($submission->replies as $reply)
        <div class="card mb-2">
            <div class="card-body">
                <p>{{ nl2br($reply->message) }}</p>
                <small class="text-muted">Sent: {{ $reply->created_at->format('Y-m-d H:i') }}</small>
            </div>
        </div>
    @endforeach
@endif

<h3>Send Reply</h3>
<form method="POST" action="{{ route('submissions.reply', $submission) }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Reply Message</label>
        <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="4" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send Reply</button>
    <a href="{{ route('submissions.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
