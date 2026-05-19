@extends('layouts.admin')

@section('title', 'Contact Details')
@section('page_title', 'Manage Contact Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Contact Details</h2>
            <p class="text-gray-600 mt-1">Manage phone numbers, emails, and social contacts</p>
        </div>
        <a href="{{ route('contact-details.create') }}" class="admin-btn-primary">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
                Add Contact
            </span>
        </a>
    </div>

    <!-- Contacts Table -->
    <div class="admin-card overflow-x-auto">
        @if($contacts && $contacts->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Icon</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td class="font-medium text-gray-900 uppercase text-sm">{{ $contact->type }}</td>
                            <td class="text-gray-600">{{ $contact->value }}</td>
                            <td class="text-gray-600 text-sm">{{ $contact->icon }}</td>
                            <td class="text-gray-600">{{ $contact->order }}</td>
                            <td>
                                <div class="flex gap-3">
                                    <a href="{{ route('contact-details.edit', $contact) }}" class="text-blue-600 hover:text-blue-700 font-medium">Edit</a>
                                    <form method="POST" action="{{ route('contact-details.destroy', $contact) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
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
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No contact details found</p>
                <a href="{{ route('contact-details.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Add your first contact</a>
            </div>
        @endif
    </div>
</div>
@endsection
