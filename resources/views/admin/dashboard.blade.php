@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h1>Admin Dashboard</h1>
<hr>

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Pages</h5>
                <p class="card-text text-primary" style="font-size: 2em;">{{ $pages_count }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Machines</h5>
                <p class="card-text text-success" style="font-size: 2em;">{{ $machines_count }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cards</h5>
                <p class="card-text text-warning" style="font-size: 2em;">{{ $cards_count }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Submissions</h5>
                <p class="card-text text-danger" style="font-size: 2em;">{{ $new_submissions }} New</p>
            </div>
        </div>
    </div>
</div>

<hr>
<h3>Recent Submissions</h3>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recent_submissions as $submission)
            <tr>
                <td>{{ $submission->name }}</td>
                <td>{{ $submission->email }}</td>
                <td>{{ $submission->subject ?? 'N/A' }}</td>
                <td><span class="badge bg-{{ $submission->status === 'new' ? 'danger' : 'success' }}">{{ ucfirst($submission->status) }}</span></td>
                <td>{{ $submission->created_at->format('Y-m-d') }}</td>
                <td><a href="{{ route('submissions.show', $submission) }}" class="btn btn-sm btn-info">View</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
