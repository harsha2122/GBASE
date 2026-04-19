<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $page->meta_description ?? 'GBASE Technologies' }}">
    <title>{{ $page->title ?? 'GBASE' }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <a href="https://api.whatsapp.com/send?phone=919315738621" class="float" target="_blank">
        <i class="fa fa-whatsapp"></i>
    </a>
    <a href="tel:+919878640088" class="float1">
        <i class="fa fa-phone"></i>
    </a>

    <!-- TOP BAR -->
    <div class="gbase-topbar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    @foreach ($contacts as $contact)
                        @if (in_array($contact->type, ['phone', 'email']))
                            <a href="{{ $contact->type === 'email' ? 'mailto:' . $contact->value : 'tel:' . $contact->value }}" style="color: #fff; margin-right: 20px;">
                                <i class="{{ $contact->icon }}"></i> {{ $contact->value }}
                            </a>
                        @endif
                    @endforeach
                </div>
                <div class="col-md-6 text-end">
                    <div class="gbase-topbar-social">
                        @foreach ($socials as $social)
                            <a href="{{ $social->url }}" target="_blank" title="{{ $social->platform }}">
                                <i class="{{ $social->icon }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <a href="/" class="logo">
                        <img src="{{ asset('images/logo/logo.png') }}" alt="GBASE">
                    </a>
                </div>
                <div class="col-md-9">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbar">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="/equipments">Equipment</a></li>
                                <li class="nav-item"><a class="nav-link" href="/freezing">Freezing</a></li>
                                <li class="nav-item"><a class="nav-link" href="/heating">Heating</a></li>
                                <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- BREADCRUMB -->
    @if ($page && $page->breadcrumb && $page->slug !== 'home')
        <nav aria-label="breadcrumb" class="breadcrumb-section">
            <div class="container-fluid">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">{{ $page->breadcrumb }}</li>
                </ol>
            </div>
        </nav>
    @endif

    <!-- MAIN CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer bg-dark text-white py-5 mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <h5>About GBASE</h5>
                    <p>GBASE Technologies specializes in food processing solutions.</p>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    @foreach ($contacts as $contact)
                        <p>{{ $contact->value }}</p>
                    @endforeach
                </div>
                <div class="col-md-4">
                    <h5>Follow Us</h5>
                    <div>
                        @foreach ($socials as $social)
                            <a href="{{ $social->url }}" target="_blank" class="text-white me-3">
                                <i class="{{ $social->icon }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr>
            <p class="text-center mb-0">&copy; 2026 GBASE Technologies. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
