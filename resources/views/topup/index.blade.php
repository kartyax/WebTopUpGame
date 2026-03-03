<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Web Top Up Game</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-900 text-white min-h-screen">
        <!-- Navbar -->
        <nav class="bg-gray-800 border-b border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-400">Web Top Up Game</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-white">Log in</a>
                            <a href="{{ route('register') }}" class="text-sm text-gray-300 hover:text-white ml-4">Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <section class="mb-12 text-center">
                <h1 class="text-4xl font-extrabold mb-4">Top Up Game Instant & Termurah</h1>
                <p class="text-gray-400 text-lg">Pilih game favoritmu dan beli diamond dengan aman 24/7.</p>
            </section>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach ($games as $game)
                <a href="{{ route('topup.show', $game->slug) }}" class="group block">
                    <div class="bg-gray-800 rounded-2xl overflow-hidden shadow-lg border border-gray-700 hover:border-indigo-500 transition-all duration-300 transform group-hover:-translate-y-2">
                        <div class="aspect-w-1 aspect-h-1 w-full bg-gray-700">
                            <!-- Placeholder Image if null -->
                            <img src="{{ $game->image_url ?? 'https://placehold.co/400x400/2d3748/fff?text='.$game->name }}" alt="{{ $game->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="font-bold text-gray-100 group-hover:text-indigo-400 transition-colors">{{ $game->name }}</h3>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </main>

        <footer class="bg-gray-800 border-t border-gray-700 mt-12 py-8 text-center text-gray-400">
            <p>&copy; 2026 Web Top Up Game. All rights reserved.</p>
        </footer>
    </body>
</html>
