@extends('layouts.admin')

@section('title', 'Contact Details')
@section('page_title', 'Contact Information')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-400 text-sm">Manage phone, email, and social contacts</p>
        </div>
        <a href="{{ route('contact-details.create') }}" class="btn-primary flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
            Add Contact
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
                            <td>
                                <span class="inline-block px-3 py-1 bg-primary/20 text-primary rounded-full text-xs font-semibold uppercase">{{ $contact->type }}</span>
                            </td>
                            <td class="font-medium text-white">{{ $contact->value }}</td>
                            <td class="text-gray-400 text-sm font-mono">{{ $contact->icon }}</td>
                            <td class="text-gray-400 text-center">{{ $contact->order }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('contact-details.edit', $contact) }}" class="text-primary hover:text-secondary font-medium text-sm">Edit</a>
                                    <form method="POST" action="{{ route('contact-details.destroy', $contact) }}" style="display: inline;" onsubmit="return confirm('Delete?');">
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
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <p class="text-gray-400">No contact details found</p>
                <a href="{{ route('contact-details.create') }}" class="text-primary hover:text-secondary mt-4 inline-block">Add your first contact →</a>
            </div>
        @endif
    </div>
</div>
@endsection
