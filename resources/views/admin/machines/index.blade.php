@extends('layouts.admin')

@section('title', 'Machines')
@section('page_title', 'Manage Machines')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Machines & Equipment</h2>
            <p class="text-gray-600 mt-1">Manage your equipment inventory</p>
        </div>
        <a href="{{ route('machines.create') }}" class="admin-btn-primary">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
                New Machine
            </span>
        </a>
    </div>

    <!-- Filters -->
    <div class="admin-card space-y-4">
        <form method="GET" action="{{ route('machines.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="admin-form-label">Search</label>
                <input type="text" name="search" placeholder="Search machines..." value="{{ request('search') }}" class="admin-form-input">
            </div>
            <div>
                <label class="admin-form-label">Category</label>
                <select name="category" class="admin-form-select">
                    <option value="">All Categories</option>
                    <option value="Pre-Process" {{ request('category') === 'Pre-Process' ? 'selected' : '' }}>Pre-Process</option>
                    <option value="Freezing" {{ request('category') === 'Freezing' ? 'selected' : '' }}>Freezing</option>
                    <option value="Heating" {{ request('category') === 'Heating' ? 'selected' : '' }}>Heating</option>
                    <option value="Sorting" {{ request('category') === 'Sorting' ? 'selected' : '' }}>Sorting</option>
                </select>
            </div>
            <div>
                <label class="admin-form-label">Assigned Page</label>
                <select name="page" class="admin-form-select">
                    <option value="">All Pages</option>
                    @foreach($pages ?? [] as $p)
                        <option value="{{ $p->slug }}" {{ request('page') === $p->slug ? 'selected' : '' }}>{{ $p->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="admin-btn-primary w-full">
                    <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"/></svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Machines Table -->
    <div class="admin-card overflow-x-auto">
        @if($machines && $machines->count() > 0)
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Assigned Page</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($machines as $machine)
                        <tr>
                            <td class="font-medium text-gray-900">{{ $machine->name }}</td>
                            <td class="text-gray-600">{{ $machine->category }}</td>
                            <td class="text-gray-600">{{ $machine->page ?? 'Unassigned' }}</td>
                            <td class="text-gray-600">{{ $machine->order }}</td>
                            <td>
                                <span class="badge-success">Active</span>
                            </td>
                            <td>
                                <div class="flex gap-3">
                                    <a href="{{ route('machines.edit', $machine) }}" class="text-blue-600 hover:text-blue-700 font-medium">Edit</a>
                                    <form method="POST" action="{{ route('machines.destroy', $machine) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
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
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6m0 0h6"/></svg>
                <p class="text-gray-500 text-lg">No machines found</p>
                <a href="{{ route('machines.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Add your first machine</a>
            </div>
        @endif
    </div>
</div>
@endsection
