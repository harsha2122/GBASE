<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - GBASE Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-slate-800 text-white shadow-lg">
            <div class="p-6 border-b border-slate-700">
                <h1 class="text-2xl font-bold">GBASE CMS</h1>
                <p class="text-sm text-slate-400 mt-1">Admin Panel</p>
            </div>

            <nav class="mt-6 px-3 space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-600' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"/></svg>
                        Dashboard
                    </span>
                </a>

                <a href="{{ route('pages.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('pages.*') ? 'bg-blue-600' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"/></svg>
                        Pages
                    </span>
                </a>

                <a href="{{ route('machines.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('machines.*') ? 'bg-blue-600' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 000-2H7zM4 7a1 1 0 011-1h10a1 1 0 011 1v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7z"/></svg>
                        Machines
                    </span>
                </a>

                <a href="{{ route('cards.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('cards.*') ? 'bg-blue-600' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>
                        Cards
                    </span>
                </a>

                <a href="{{ route('contact-details.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('contact-details.*') ? 'bg-blue-600' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06m0 0l1.321 3.982a1 1 0 01-.923 1.417H7a1 1 0 01-1-1v-2.396m0 0V5m0 0H3"/></svg>
                        Contacts
                    </span>
                </a>

                <a href="{{ route('submissions.index') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition-colors {{ request()->routeIs('submissions.*') ? 'bg-blue-600' : '' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M2.5 1A1.5 1.5 0 001 2.5v15A1.5 1.5 0 002.5 19h15a1.5 1.5 0 001.5-1.5v-15A1.5 1.5 0 0017.5 1h-15zm0 1h15v15h-15v-15z"/></svg>
                        Submissions
                    </span>
                </a>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
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
            <!-- Header -->
            <header class="bg-white shadow-md z-10">
                <div class="px-8 py-4 flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600 text-sm">{{ auth()->user()->email ?? 'Admin' }}</span>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-auto bg-gray-50 p-8">
                <!-- Alerts -->
                @if ($errors->any())
                    <div class="alert-error mb-6">
                        <h3 class="font-semibold mb-2">Errors:</h3>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert-success mb-6" x-data="{ open: true }" x-show="open" @click.away="open = false">
                        <div class="flex justify-between items-start">
                            <span>{{ session('success') }}</span>
                            <button @click="open = false" class="text-green-800 hover:text-green-900">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"/></svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-error mb-6" x-data="{ open: true }" x-show="open" @click.away="open = false">
                        <div class="flex justify-between items-start">
                            <span>{{ session('error') }}</span>
                            <button @click="open = false" class="text-red-800 hover:text-red-900">
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
