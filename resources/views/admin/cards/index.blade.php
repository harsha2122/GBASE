@extends('layouts.admin')

@section('title', 'Service Cards')
@section('page_title', 'Manage Service Cards')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Service Cards</h2>
            <p class="text-gray-600 mt-1">Manage service/feature cards</p>
        </div>
        <a href="{{ route('cards.create') }}" class="admin-btn-primary">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
                New Card
            </span>
        </a>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($cards && $cards->count() > 0)
            @foreach($cards as $card)
                <div class="admin-card">
                    @if($card->image)
                        <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->title }}" class="w-full h-40 object-cover rounded-lg mb-4">
                    @endif
                    <h3 class="text-lg font-bold text-gray-800">{{ $card->title }}</h3>
                    <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ $card->description }}</p>
                    <p class="text-gray-500 text-xs mt-3">Page: {{ $card->page ?? 'Unassigned' }}</p>
                    <div class="flex gap-3 mt-4">
                        <a href="{{ route('cards.edit', $card) }}" class="flex-1 text-center text-blue-600 hover:text-blue-700 font-medium">Edit</a>
                        <form method="POST" action="{{ route('cards.destroy', $card) }}" style="display: inline; flex: 1;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-red-600 hover:text-red-700 font-medium">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-span-full text-center py-12 admin-card">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6m0 0h6"/></svg>
                <p class="text-gray-500 text-lg">No cards found</p>
                <a href="{{ route('cards.create') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">Create your first card</a>
            </div>
        @endif
    </div>
</div>
@endsection
