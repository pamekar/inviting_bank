<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inviting Bank - Your Partner in Growth</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --brand-purple: #7c3aed;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-white" x-data="{ open: false }">
<div class="min-h-screen flex flex-col">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center py-4">
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('img/logo.png') }}" alt="Inviting Bank Logo" class="h-16">
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('about') }}" class="text-gray-600 hover:text-purple-700">About Us</a>
                <a href="{{ route('contact') }}" class="text-gray-600 hover:text-purple-700">Contact</a>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <a href="{{ route('register') }}"
                       class="bg-purple-700 text-white px-4 py-2 rounded-md hover:bg-purple-800">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-purple-700">Log in</a>
                    <a href="{{ route('dashboard') }}"
                       class="bg-purple-700 text-white px-4 py-2 rounded-md hover:bg-purple-800">Register</a>
                @endif
            </div>
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="open = !open" class="text-gray-600 hover:text-purple-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </nav>
        <!-- Mobile Menu -->
        <div x-show="open" @click.away="open = false" class="md:hidden bg-white border-t">
            <a href="{{ route('about') }}" class="block py-2 px-4 text-sm text-gray-600 hover:bg-gray-50">About Us</a>
            <a href="{{ route('contact') }}" class="block py-2 px-4 text-sm text-gray-600 hover:bg-gray-50">Contact</a>
            <a href="{{ route('login') }}" class="block py-2 px-4 text-sm text-gray-600 hover:bg-gray-50">Log in</a>
            <a href="{{ route('register') }}"
               class="block py-2 px-4 text-sm text-gray-600 hover:bg-gray-50">Register</a>
        </div>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <img src="{{ asset('img/logo.png') }}" alt="Inviting Bank Logo" class="h-16">
                    <p class="mt-2 text-gray-400">Your partner in growth.</p>
                </div>
                <div>
                    <h4 class="font-semibold">Quick Links</h4>
                    <ul class="mt-4 space-y-2">
                        <li><a href="/" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold">Legal</h4>
                    <ul class="mt-4 space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Inviting Bank. All Rights Reserved.</p>
                <p class="mt-2 text-sm text-gray-500">This is just a demo bank to easily simulate the integration of chat AI solutions into fintech solutions.</p>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
