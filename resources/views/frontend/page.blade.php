@extends('layouts.frontend')

@section('content')
@if ($page->hero_image)
    <div style="background: url('{{ asset('storage/' . $page->hero_image) }}') center/cover; height: 300px; color: white; display: flex; align-items: center; justify-content: center;">
        <h1 class="text-white">{{ $page->title }}</h1>
    </div>
@else
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 80px 0; text-align: center;">
        <h1 class="display-4">{{ $page->title }}</h1>
    </div>
@endif

<div class="container-fluid py-5">
    @if ($page->content)
        <div class="row">
            <div class="col-md-8">
                {!! nl2br($page->content) !!}
            </div>
        </div>
    @endif

    @if ($cards->count())
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="mb-4">{{ $page->title }} Services</h2>
            </div>
            @foreach ($cards as $card)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        @if ($card->image)
                            <img src="{{ asset('storage/' . $card->image) }}" class="card-img-top" alt="{{ $card->title }}">
                        @elseif ($card->icon)
                            <div style="background: #f0f0f0; padding: 30px; text-align: center; font-size: 2.5em;">
                                <i class="{{ $card->icon }}"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $card->title }}</h5>
                            <p class="card-text">{{ $card->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if ($machines->count())
        <div class="row mt-5">
            <div class="col-12">
                <h2 class="mb-4">Equipment</h2>
            </div>
            @foreach ($machines as $machine)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        @if ($machine->image)
                            <img src="{{ asset('storage/' . $machine->image) }}" class="card-img-top" alt="{{ $machine->name }}">
                        @else
                            <div style="background: #e9ecef; height: 180px; display: flex; align-items: center; justify-content: center;">
                                <span class="text-muted">No Image</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $machine->name }}</h5>
                            <small class="text-muted">{{ $machine->category }}</small>
                            <p class="card-text small mt-2">{{ substr($machine->description ?? 'Advanced equipment', 0, 80) }}...</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@if ($page->slug === 'contact')
    <section style="background: #f8f9fa; padding: 50px 0;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h2 class="mb-4">Send us a Message</h2>
                    <form method="POST" action="{{ route('submission.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" name="phone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endif
@endsection
