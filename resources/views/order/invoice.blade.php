<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameUp - Invoice {{ $order->invoice_number }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
    <script src="//unpkg.com/alpinejs" defer></script>
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
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
        <div class="bg-[#161920] rounded-2xl p-6 md:p-10 shadow-sm border border-gray-800/80">
            <div class="text-center mb-10 border-b border-gray-800/80 pb-8">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-2">Nomor Invoice</p>
                <h1 class="text-2xl md:text-3xl font-bold font-mono tracking-wider text-white">{{ $order->invoice_number }}</h1>
                
                <div class="mt-5">
                    @if($order->status === 'UNPAID')
                        <span class="inline-block px-5 py-1.5 rounded-lg text-xs font-bold bg-[#fcb045]/10 text-[#fcb045] border border-[#fcb045]/20 tracking-wide">BELUM DIBAYAR</span>
                    @elseif($order->status === 'SUCCESS')
                        <span class="inline-block px-5 py-1.5 rounded-lg text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 tracking-wide">BERHASIL DIBAYAR</span>
                    @else
                        <span class="inline-block px-5 py-1.5 rounded-lg text-xs font-bold bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 tracking-wide">{{ $order->status }}</span>
                    @endif
                </div>
            </div>

            @if(session('success'))
            <div class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 p-4 rounded-xl mb-8 flex items-center gap-3 text-sm font-medium">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="bg-[#1a1c22] p-5 rounded-xl border border-gray-800">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5">Game</h3>
                    <p class="font-bold text-gray-200 mb-5">{{ $order->game->name }}</p>

                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5">Produk</h3>
                    <p class="font-bold text-gray-200 mb-5">{{ $order->product->name }}</p>
                    
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5">ID Pemain</h3>
                    <p class="font-bold text-gray-200">
                        {{ $order->game_user_id }}
                        @if($order->game_server_id) <span class="text-gray-500">({{ $order->game_server_id }})</span> @endif
                    </p>
                </div>
                <div class="bg-[#1a1c22] p-5 rounded-xl border border-gray-800">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5">Metode Bayar</h3>
                    <p class="font-bold text-gray-200 mb-5">{{ $order->paymentMethod->name }}</p>

                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5">No. Telepon</h3>
                    <p class="font-bold text-gray-200 mb-5">{{ $order->customer_phone }}</p>

                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5">Waktu Transaksi</h3>
                    <p class="font-bold text-gray-200">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <div class="bg-[#1a1c22] rounded-xl p-6 md:p-8 border border-gray-800 mb-8 shadow-sm">
                <div class="flex justify-between items-center mb-4 text-gray-400 font-medium">
                    <span class="text-sm">Harga Pembelian</span>
                    <span>Rp {{ number_format($order->original_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center mb-4 text-gray-400 font-medium">
                    <span class="text-sm">Biaya Admin</span>
                    <span>Rp {{ number_format($order->fee, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-gray-800/80 mt-6 pt-6 flex justify-between items-center">
                    <span class="font-bold text-gray-300 text-lg uppercase tracking-wider">Total</span>
                    <span class="font-bold text-2xl text-cyan-400 tracking-tight">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($order->status === 'UNPAID')
                <!-- Simulation form strictly for demo -->
                <form action="{{ route('order.simulate-pay', $order->invoice_number) }}" method="POST" class="mt-10">
                    @csrf
                    <div class="border border-cyan-500/20 bg-cyan-500/5 rounded-xl p-5 mb-6 text-center shadow-inner">
                        <p class="text-gray-400 text-sm mb-4">Dalam environment demo/testing, Anda dapat mensimulasikan pembayaran lunas di sini.</p>
                        <button type="submit" class="bg-cyan-600 hover:bg-cyan-500 text-white font-bold tracking-widest uppercase py-3.5 px-8 rounded-lg transition-all focus:outline-none focus:ring-4 focus:ring-cyan-500/30 shadow-lg hover:shadow-cyan-500/20 text-sm w-full md:w-auto">
                            Simulasi Bayar Lunas
                        </button>
                    </div>
                </form>
            @endif

            <div class="text-center mt-10 space-y-4">
                <a href="{{ route('home') }}" class="inline-block text-sm font-medium text-gray-500 hover:text-cyan-400 transition-colors uppercase tracking-widest">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>
</body>
</html>
