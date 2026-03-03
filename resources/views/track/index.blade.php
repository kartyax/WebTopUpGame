<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameUp - Lacak Pesanan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="antialiased bg-[#111318] text-gray-200 min-h-screen selection:bg-cyan-500/30">
    <!-- Navbar -->
    <nav class="border-b border-gray-800/60 bg-[#161920]/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-white tracking-tight flex items-center gap-2">
                        <span class="text-cyan-400 text-2xl leading-none">&plus;</span> GAME<span class="text-gray-400 font-normal">UP</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-10 text-sm font-medium">
                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors py-5">Home</a>
                    <a href="{{ route('track.index') }}" class="text-white border-b-2 border-cyan-400 py-5">Track Order</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight">Lacak Pesanan</h1>
            <p class="text-gray-400 text-base font-medium">Masukkan nomor invoice untuk melihat status pesanan kamu.</p>
        </div>

        @if(session('error'))
        <div class="bg-red-500/10 text-red-400 border border-red-500/30 p-4 rounded-xl mb-6 flex items-center gap-3 text-sm font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('track.search') }}" method="POST">
            @csrf
            <div class="bg-[#161920] rounded-2xl p-6 md:p-8 border border-gray-800/80 shadow-sm">
                <label class="block text-xs font-semibold text-gray-400 mb-3 uppercase tracking-wider">Nomor Invoice</label>
                <input type="text" name="invoice" value="{{ old('invoice') }}" required
                    class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-4 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-mono font-medium transition-all hover:border-gray-700 text-center text-lg tracking-wider"
                    placeholder="INV-XXXXXXXX-XXXXX">

                <button type="submit" class="w-full mt-6 bg-cyan-600 hover:bg-cyan-500 text-white font-bold tracking-widest uppercase py-4 rounded-xl transition-all focus:outline-none focus:ring-4 focus:ring-cyan-500/30 shadow-lg hover:shadow-cyan-500/20 text-sm">
                    Cari Pesanan
                </button>
            </div>
        </form>

        <div class="text-center mt-10">
            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-cyan-400 transition-colors">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </main>
</body>
</html>
