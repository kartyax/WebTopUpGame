<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Top Up {{ $game->name }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="bg-gray-900 text-white font-sans antialiased min-h-screen">
        <!-- Navbar -->
        <nav class="bg-gray-800 border-b border-gray-700 mb-8">
            <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
                <a href="{{ route('home') }}" class="font-bold text-indigo-400 text-xl flex items-center gap-2">
                    &larr; <span class="text-white hidden sm:block">Kembali</span>
                </a>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Sidebar: Game Info -->
                <div class="w-full md:w-1/3">
                    <div class="bg-gray-800 rounded-2xl p-6 shadow-lg sticky top-6">
                        <img src="{{ $game->image_url ?? 'https://placehold.co/400x400/2d3748/fff?text='.$game->name }}" alt="{{ $game->name }}" class="w-full rounded-xl mb-4 shadow">
                        <h2 class="text-2xl font-bold mb-2">{{ $game->name }}</h2>
                        <p class="text-gray-400 text-sm leading-relaxed mb-4">
                            {{ $game->description }}
                        </p>
                        <div class="bg-indigo-900/40 text-indigo-300 p-3 rounded-lg text-sm border border-indigo-500/30">
                            <strong>Cara Top Up:</strong>
                            <ol class="list-decimal ml-4 mt-2 space-y-1">
                                <li>Masukkan ID Pemain.</li>
                                <li>Pilih Nominal Top Up.</li>
                                <li>Pilih Pembayaran.</li>
                                <li>Klik Beli & Lakukan Pembayaran.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Main Section: Form Top Up -->
                <div class="w-full md:w-2/3" x-data="{
                        userId: '',
                        serverId: '',
                        selectedProduct: null,
                        selectedPayment: null,
                        phone: '',
                    }">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                        
                        <!-- Step 1: User ID -->
                        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg mb-6 border border-gray-700">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-indigo-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">1</span>
                                <h3 class="text-xl font-bold">Masukkan ID Game</h3>
                            </div>
                            <div class="grid grid-cols-1 {{ $game->has_server_id ? 'md:grid-cols-2' : '' }} gap-4">
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">User ID <span class="text-red-500">*</span></label>
                                    <input type="text" x-model="userId" name="user_id_input" required class="w-full bg-gray-900 border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white placeholder-gray-500" placeholder="Masukkan User ID">
                                </div>
                                @if($game->has_server_id)
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Server ID / Zone ID <span class="text-red-500">*</span></label>
                                    <input type="text" x-model="serverId" name="server_id_input" required class="w-full bg-gray-900 border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white placeholder-gray-500" placeholder="Masukkan Server ID">
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Step 2: Nominal Top Up -->
                        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg mb-6 border border-gray-700">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-indigo-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">2</span>
                                <h3 class="text-xl font-bold">Pilih Nominal</h3>
                            </div>
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                                @forelse($game->products as $product)
                                    <label class="cursor-pointer">
                                        <input type="radio" class="hidden peer" name="product_id" value="{{ $product->id }}" @change="selectedProduct = {{ $product->price }}">
                                        <div class="bg-gray-900 border border-gray-600 rounded-xl p-4 text-center hover:border-indigo-400 peer-checked:border-indigo-500 peer-checked:bg-indigo-900/30 transition-all">
                                            <p class="font-bold text-white mb-1">{{ $product->name }}</p>
                                            <p class="text-sm text-indigo-400">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-red-400 italic">Produk belum tersedia untuk game ini.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Step 3: Pembayaran -->
                        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg mb-6 border border-gray-700" x-show="selectedProduct !== null" style="display: none;">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-indigo-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">3</span>
                                <h3 class="text-xl font-bold">Pilih Pembayaran</h3>
                            </div>
                            <div class="space-y-4">
                                @foreach($paymentMethods as $payment)
                                    <label class="block cursor-pointer">
                                        <input type="radio" class="hidden peer" name="payment_method_id" value="{{ $payment->id }}" @change="selectedPayment = {{ $payment->fee_flat }}">
                                        <div class="bg-gray-900 border border-gray-600 rounded-xl p-4 flex justify-between items-center hover:border-indigo-400 peer-checked:border-indigo-500 peer-checked:bg-indigo-900/30 transition-all">
                                            <div>
                                                <p class="font-bold text-lg flex items-center gap-2">
                                                    {{ $payment->name }}
                                                </p>
                                                <p class="text-sm text-gray-400 border-t border-gray-700 mt-2 pt-2">+ Fee: Rp <span x-text="new Intl.NumberFormat('id-ID').format({{ $payment->fee_flat }})"></span></p>
                                            </div>
                                            <!-- Total Simulation -->
                                            <div class="text-right peer-checked:block hidden transition-all">
                                                <p class="text-xs text-gray-400">Total Bayar</p>
                                                <p class="text-indigo-400 font-bold text-xl" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedProduct + {{ $payment->fee_flat }})"></p>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Step 4: Kontak WhatsApp -->
                        <div class="bg-gray-800 rounded-2xl p-6 shadow-lg mb-6 border border-gray-700">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-indigo-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">4</span>
                                <h3 class="text-xl font-bold">Nomor WhatsApp</h3>
                            </div>
                            <div>
                                <input type="number" x-model="phone" name="phone" required class="w-full bg-gray-900 border border-gray-600 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-white placeholder-gray-500" placeholder="081xxx">
                                <p class="text-xs text-gray-400 mt-2">* Bukti pembelian dan status pesanan akan dikirim via WhatsApp.</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-lg py-4 rounded-xl shadow-lg transition-all focus:outline-none focus:ring-4 focus:ring-indigo-500/50 flex items-center justify-center gap-2">
                            <span>Beli Sekarang</span>
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </body>
</html>
