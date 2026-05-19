@extends('layouts.admin')

@section('title', 'Machines')
@section('page_title', 'Equipment & Machines')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-400 text-sm">Manage all equipment and assign to pages</p>
        </div>
        <a href="{{ route('machines.create') }}" class="btn-success flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
            Add Machine
        </a>
    </div>

    <!-- Filters -->
    <div class="admin-card">
        <form method="GET" action="{{ route('machines.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="admin-form-label text-xs">Search Machine</label>
                <input type="text" name="search" placeholder="Machine name..." value="{{ request('search') }}" class="admin-form-input">
            </div>
            <div>
                <label class="admin-form-label text-xs">Category</label>
                <select name="category" class="admin-form-select">
                    <option value="">All Categories</option>
                    <option value="Pre-Process" {{ request('category') === 'Pre-Process' ? 'selected' : '' }}>Pre-Process</option>
                    <option value="Freezing" {{ request('category') === 'Freezing' ? 'selected' : '' }}>Freezing</option>
                    <option value="Heating" {{ request('category') === 'Heating' ? 'selected' : '' }}>Heating</option>
                    <option value="Sorting" {{ request('category') === 'Sorting' ? 'selected' : '' }}>Sorting</option>
                </select>
            </div>
            <div>
                <label class="admin-form-label text-xs">Assigned Page</label>
                <select name="page" class="admin-form-select">
                    <option value="">All Pages</option>
                    @foreach($pages ?? [] as $p)
                        <option value="{{ $p->slug }}" {{ request('page') === $p->slug ? 'selected' : '' }}>{{ $p->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full">
                    <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"/></svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Machines Grid/Table -->
    <div class="admin-card overflow-x-auto">
        @if($machines && $machines->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Machine Name</th>
                        <th>Category</th>
                        <th>Page Assignment</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($machines as $machine)
                        <tr>
                            <td>
                                <div class="font-semibold text-white">{{ $machine->name }}</div>
                                <p class="text-gray-400 text-xs mt-1">{{ Str::limit($machine->description, 40) }}</p>
                            </td>
                            <td>
                                <span class="inline-block px-3 py-1 bg-primary/20 text-primary rounded-full text-xs font-medium">{{ $machine->category }}</span>
                            </td>
                            <td class="text-gray-400">
                                {{ $machine->page ? ucfirst($machine->page) : '—' }}
                            </td>
                            <td class="text-gray-400 text-center">{{ $machine->order }}</td>
                            <td>
                                <span class="inline-block px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-xs font-medium">Active</span>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('machines.edit', $machine) }}" class="text-primary hover:text-secondary font-medium text-sm">Edit</a>
                                    <form method="POST" action="{{ route('machines.destroy', $machine) }}" style="display: inline;" onsubmit="return confirm('Delete this machine?');">
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

            @if($machines->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $machines->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-gray-400 text-lg">No machines found</p>
                <a href="{{ route('machines.create') }}" class="text-primary hover:text-secondary mt-4 inline-block">Add your first machine →</a>
            </div>
        @endif
    </div>
</div>
@endsection
