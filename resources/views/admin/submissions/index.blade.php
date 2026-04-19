@extends('layouts.admin')

@section('title', 'Submissions')

@section('content')
<h1>Contact Form Submissions</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($submissions as $submission)
            <tr>
                <td>{{ $submission->name }}</td>
                <td>{{ $submission->email }}</td>
                <td>{{ $submission->phone ?? '-' }}</td>
                <td>{{ $submission->subject ?? '-' }}</td>
                <td><span class="badge bg-{{ $submission->status === 'new' ? 'danger' : 'success' }}">{{ ucfirst($submission->status) }}</span></td>
                <td>{{ $submission->created_at->format('Y-m-d H:i') }}</td>
                <td>
                    <a href="{{ route('submissions.show', $submission) }}" class="btn btn-sm btn-info">View</a>
                    <form method="POST" action="{{ route('submissions.destroy', $submission) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $submissions->links() }}
@endsection
