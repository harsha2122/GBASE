<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - GBASE Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; }
        .sidebar { width: 250px; background: #343a40; color: white; min-height: 100vh; padding: 20px 0; }
        .sidebar a { color: white; display: block; padding: 10px 20px; text-decoration: none; }
        .sidebar a:hover { background: #23272b; }
        .main-content { flex: 1; padding: 30px; }
        .alert { margin-bottom: 20px; }
        .btn-primary { background-color: #0066cc; border: none; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-white ps-3">GBASE CMS</h4>
        <hr>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('pages.index') }}">Pages</a>
        <a href="{{ route('machines.index') }}">Machines</a>
        <a href="{{ route('cards.index') }}">Cards</a>
        <a href="{{ route('contact-details.index') }}">Contact Details</a>
        <a href="{{ route('submissions.index') }}">Submissions</a>
        <hr>
        <div class="ps-3">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-light">Logout</button>
            </form>
        </div>
    </div>
    <div class="main-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
