@extends('layouts.frontend')

@section('content')
<div class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 100px 0; text-align: center;">
    <div class="container-fluid">
        <h1 class="display-4">Welcome to GBASE Technologies</h1>
        <p class="lead">Food Processing Solutions & Equipment</p>
    </div>
</div>

@if ($cards->count())
    <section class="services-section py-5">
        <div class="container-fluid">
            <h2 class="text-center mb-5">Our Services</h2>
            <div class="row">
                @foreach ($cards as $card)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if ($card->image)
                                <img src="{{ asset('storage/' . $card->image) }}" class="card-img-top" alt="{{ $card->title }}">
                            @elseif ($card->icon)
                                <div style="background: #f0f0f0; padding: 40px; text-align: center; font-size: 3em;">
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
        </div>
    </section>
@endif

@if ($machines->count())
    <section class="machines-section py-5" style="background: #f8f9fa;">
        <div class="container-fluid">
            <h2 class="text-center mb-5">Our Equipment</h2>
            <div class="row">
                @foreach ($machines->take(6) as $machine)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            @if ($machine->image)
                                <img src="{{ asset('storage/' . $machine->image) }}" class="card-img-top" alt="{{ $machine->name }}">
                            @else
                                <div style="background: #e9ecef; height: 200px; display: flex; align-items: center; justify-content: center;">
                                    <span class="text-muted">No Image</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $machine->name }}</h5>
                                <small class="text-muted">{{ $machine->category }}</small>
                                <p class="card-text small mt-2">{{ $machine->description ? substr($machine->description, 0, 100) . '...' : 'Advanced food processing equipment' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="cta-section py-5" style="background: #667eea; color: white; text-align: center;">
    <div class="container-fluid">
        <h2>Ready to Get Started?</h2>
        <p class="lead">Contact us for a consultation</p>
        <a href="/contact" class="btn btn-light btn-lg">Contact Us</a>
    </div>
</section>
@endsection
