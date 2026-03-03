<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $order->invoice_number }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-900 text-white font-sans antialiased min-h-screen">
    <!-- Navbar -->
    <nav class="bg-gray-800 border-b border-gray-700 mb-8">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-bold text-indigo-400 text-xl">Web Top Up Game</a>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        @if(session('success'))
        <div class="bg-green-500/20 text-green-400 border border-green-500/50 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-gray-800 rounded-2xl p-8 shadow-lg border border-gray-700">
            <div class="text-center mb-8 border-b border-gray-700 pb-6">
                <p class="text-gray-400 text-sm">Nomor Invoice</p>
                <h1 class="text-2xl md:text-3xl font-bold font-mono tracking-wider">{{ $order->invoice_number }}</h1>
                
                <div class="mt-4">
                    @if($order->status === 'UNPAID')
                        <span class="inline-block px-4 py-1.5 rounded-full text-sm font-bold bg-yellow-500/20 text-yellow-500 border border-yellow-500/30">BELUM DIBAYAR</span>
                    @elseif($order->status === 'SUCCESS')
                        <span class="inline-block px-4 py-1.5 rounded-full text-sm font-bold bg-green-500/20 text-green-500 border border-green-500/30">BERHASIL</span>
                    @else
                        <span class="inline-block px-4 py-1.5 rounded-full text-sm font-bold bg-blue-500/20 text-blue-500 border border-blue-500/30">{{ $order->status }}</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-gray-400 text-sm mb-1">Detail Pesanan</h3>
                    <p class="font-bold text-lg mb-4">{{ $order->game->name }} - {{ $order->product->name }}</p>
                    
                    <h3 class="text-gray-400 text-sm mb-1">ID Pemain</h3>
                    <p class="font-bold text-lg mb-4">
                        {{ $order->game_user_id }}
                        @if($order->game_server_id) ({{ $order->game_server_id }}) @endif
                    </p>
                </div>
                <div>
                    <h3 class="text-gray-400 text-sm mb-1">Metode Pembayaran</h3>
                    <p class="font-bold text-lg mb-4">{{ $order->paymentMethod->name }}</p>

                    <h3 class="text-gray-400 text-sm mb-1">Nomor WhatsApp</h3>
                    <p class="font-bold text-lg mb-4">{{ $order->customer_phone }}</p>
                </div>
            </div>

            <div class="bg-gray-900 rounded-xl p-6 border border-gray-700 mb-8">
                <div class="flex justify-between mb-3 text-gray-300">
                    <span>Harga Item</span>
                    <span>Rp {{ number_format($order->original_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mb-3 text-gray-300">
                    <span>Biaya Admin</span>
                    <span>Rp {{ number_format($order->fee, 0, ',', '.') }}</span>
                </div>
                <div class="border-t border-gray-700 mt-4 pt-4 flex justify-between font-bold text-xl text-indigo-400">
                    <span>Total Pembayaran</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($order->status === 'UNPAID')
                <!-- Simulation form strictly for demo -->
                <form action="{{ route('order.simulate-pay', $order->invoice_number) }}" method="POST" class="text-center">
                    @csrf
                    <p class="text-gray-400 text-sm mb-4">Untuk demo payment gateway, klik tombol di bawah ini (Simulasi Bayar).</p>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-bold py-4 rounded-xl shadow-lg transition-all focus:outline-none focus:ring-4 focus:ring-green-500/50">
                        Simulasi Bayar Lunas
                    </button>
                </form>
            @endif

            @if($order->status === 'SUCCESS')
                <div class="text-center">
                    <a href="{{ route('home') }}" class="w-full inline-block bg-gray-700 hover:bg-gray-600 text-white font-bold py-4 rounded-xl transition-all">
                        Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </main>
</body>
</html>
