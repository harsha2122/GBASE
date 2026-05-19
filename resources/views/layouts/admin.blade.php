<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - GBASE Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-darker">
    <div class="flex h-screen bg-darker">
        <!-- Sidebar -->
        <div class="w-72 bg-darker border-r border-border flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-border">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM15.657 14.243a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM11 17a1 1 0 102 0v-1a1 1 0 10-2 0v1zM5.757 15.657a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zM5.757 4.343a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">GBASE</h1>
                        <p class="text-xs text-gray-400">CMS Control</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"/></svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('pages.index') }}" class="sidebar-item {{ request()->routeIs('pages.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"/></svg>
                    <span>Pages</span>
                </a>

                <a href="{{ route('machines.index') }}" class="sidebar-item {{ request()->routeIs('machines.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 000-2H7zM4 7a1 1 0 011-1h10a1 1 0 011 1v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"/></svg>
                    <span>Machines</span>
                </a>

                <a href="{{ route('cards.index') }}" class="sidebar-item {{ request()->routeIs('cards.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"/></svg>
                    <span>Service Cards</span>
                </a>

                <a href="{{ route('contact-details.index') }}" class="sidebar-item {{ request()->routeIs('contact-details.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06m0 0l1.321 3.982a1 1 0 01-.923 1.417H7a1 1 0 01-1-1v-2.396m0 0V5m0 0H3"/></svg>
                    <span>Contacts</span>
                </a>

                <a href="{{ route('submissions.index') }}" class="sidebar-item {{ request()->routeIs('submissions.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2.5 1A1.5 1.5 0 001 2.5v15A1.5 1.5 0 002.5 19h15a1.5 1.5 0 001.5-1.5v-15A1.5 1.5 0 0017.5 1h-15zm0 1h15v15h-15v-15z"/></svg>
                    <span>Submissions</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-border">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full btn-danger py-2">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"/></svg>
                            Logout
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-card border-b border-border z-10 shadow-lg">
                <div class="px-8 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white">@yield('page_title', 'Dashboard')</h2>
                    <div class="flex items-center space-x-6">
                        <div class="text-right">
                            <p class="text-gray-300 text-sm">{{ auth()->user()->email ?? 'Administrator' }}</p>
                            <p class="text-gray-500 text-xs">Admin Account</p>
                        </div>
                        <div class="w-10 h-10 bg-gradient-primary rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">{{ strtoupper(substr(auth()->user()->email ?? 'A', 0, 1)) }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-auto bg-darker p-8">
                <!-- Alerts -->
                @if ($errors->any())
                    <div class="alert-error mb-6" x-data="{ open: true }" x-show="open">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold mb-2">Please fix the following errors:</h3>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button @click="open = false" class="ml-4">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert-success mb-6" x-data="{ open: true }" x-show="open" x-init="setTimeout(() => open = false, 5000)">
                        <div class="flex justify-between items-start">
                            <span>✓ {{ session('success') }}</span>
                            <button @click="open = false">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-error mb-6" x-data="{ open: true }" x-show="open">
                        <div class="flex justify-between items-start">
                            <span>✗ {{ session('error') }}</span>
                            <button @click="open = false">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
