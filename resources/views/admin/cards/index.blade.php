@extends('layouts.admin')

@section('title', 'Service Cards')
@section('page_title', 'Service Cards')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-gray-400 text-sm">Manage feature and service cards</p>
        </div>
        <a href="{{ route('cards.create') }}" class="btn-primary flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
            New Card
        </a>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($cards && $cards->count() > 0)
            @foreach($cards as $card)
                <div class="admin-card group hover:shadow-xl hover:shadow-primary/20 transition-all">
                    @if($card->image)
                        <div class="mb-4 overflow-hidden rounded-lg h-40">
                            <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        </div>
                    @else
                        <div class="mb-4 bg-gradient-primary rounded-lg h-40 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/></svg>
                        </div>
                    @endif
                    
                    <h3 class="text-lg font-bold text-white mb-2">{{ $card->title }}</h3>
                    <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $card->description }}</p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-border">
                        <span class="text-xs text-gray-500">{{ $card->page ? 'Page: ' . $card->page : 'Unassigned' }}</span>
                        <div class="flex gap-2">
                            <a href="{{ route('cards.edit', $card) }}" class="text-primary hover:text-secondary font-medium text-xs">Edit</a>
                            <form method="POST" action="{{ route('cards.destroy', $card) }}" style="display: inline;" onsubmit="return confirm('Delete?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 font-medium text-xs">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-span-full admin-card text-center py-16">
                <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                <p class="text-gray-400">No cards created yet</p>
                <a href="{{ route('cards.create') }}" class="text-primary hover:text-secondary mt-4 inline-block">Create your first card →</a>
            </div>
        @endif
    </div>
</div>
@endsection
