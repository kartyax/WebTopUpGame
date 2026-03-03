<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameUp - Minimalist Top Up</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="antialiased bg-[#14151a] text-gray-200 min-h-screen selection:bg-cyan-500/30">
    <!-- Navbar -->
    <nav class="border-b border-gray-800/60 bg-[#1a1c22]/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-white tracking-tight flex items-center gap-2">
                        <span class="text-cyan-400 text-2xl leading-none">&plus;</span> GAME<span class="text-gray-400 font-normal">UP</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-10 text-sm font-medium">
                    <a href="{{ route('home') }}" class="text-white border-b-2 border-cyan-400 py-5">Home</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors py-5">Games</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors py-5">Track Order</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors py-5">Support</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="text-sm font-medium bg-[#21242b] hover:bg-[#2b2f38] text-white px-4 py-2 rounded-lg border border-gray-700/50 transition-all ml-2 shadow-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <!-- Hero Section -->
        <section class="mb-16 text-center max-w-3xl mx-auto flex flex-col items-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 tracking-tight leading-tight">
                ELEVATE YOUR GAME.
            </h1>
            <p class="text-gray-400 text-lg md:text-xl font-medium mb-10 max-w-2xl px-4">
                Instant, secure, and seamless top-ups for your favorite games. Minimal friction, ultimate performance.
            </p>

            <!-- Search bar minimalis -->
            <div class="relative w-full max-w-lg">
                <input type="text" placeholder="Search games or direct top-up..." class="w-full bg-[#1a1c22] border border-gray-800 text-white rounded-xl px-5 py-4 pl-14 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 transition-all placeholder-gray-500 shadow-inner">
                <svg class="w-5 h-5 absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </section>

        <!-- Section Title -->
        <div class="flex items-center justify-between mb-8 pb-3 border-b border-gray-800/80">
            <h2 class="text-lg font-bold text-white tracking-widest uppercase">Popular Games</h2>
            <a href="#" class="text-sm font-medium text-cyan-400 hover:text-cyan-300">View All</a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 md:gap-8">
            @foreach ($games as $game)
            <a href="{{ route('topup.show', $game->slug) }}" class="group block">
                <div class="bg-[#1a1c22] rounded-2xl overflow-hidden border border-gray-800 hover:border-cyan-500/40 hover:bg-[#1f2229] transition-all duration-300 transform group-hover:-translate-y-1 shadow-sm hover:shadow-cyan-500/10">
                    <div class="aspect-w-1 aspect-h-1 w-full bg-[#14151a]">
                        <img src="{{ $game->image_url ?? 'https://placehold.co/400x400/14151a/8B5CF6?text=' . urlencode($game->name) }}" alt="{{ $game->name }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-gray-100 group-hover:text-cyan-400 transition-colors tracking-wide text-lg mb-1">{{ $game->name }}</h3>
                        <p class="text-xs text-gray-500 font-medium tracking-wide">Direct Top-Up</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </main>

    <footer class="mt-20 py-8 text-center text-gray-500 border-t border-gray-800/60 bg-[#111318]">
        <p class="text-sm">&copy; 2026 GameUp. Platform minimalis top up idaman gamers.</p>
    </footer>
</body>
</html>
