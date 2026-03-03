<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameUp - Top Up {{ $game->name }}</title>
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2 w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>

        <div class="flex flex-col md:flex-row gap-8 lg:gap-10">
            <!-- Sidebar: Game Info Minimalist -->
            <div class="w-full md:w-1/3 lg:w-1/4">
                <div class="bg-[#161920] rounded-2xl p-6 shadow-sm border border-gray-800/80 sticky top-24">
                    <div class="rounded-xl overflow-hidden aspect-w-4 aspect-h-5 mb-5 border border-gray-800">
                        <img src="{{ $game->image_url ?? 'https://placehold.co/400x500/14151a/8B5CF6?text='.urlencode($game->name) }}" alt="{{ $game->name }}" class="w-full h-full object-cover">
                    </div>
                    <h2 class="text-xl font-bold text-white mb-2">{{ $game->name }}</h2>
                    <p class="text-gray-400 text-sm leading-relaxed mb-5">
                        {{ $game->description }}
                    </p>
                    <div class="bg-[#1a1c22] rounded-xl p-4 border border-gray-800 text-sm">
                        <h4 class="font-semibold text-gray-300 mb-2">Panduan Cepat</h4>
                        <ol class="list-decimal text-gray-500 ml-4 space-y-1 text-xs font-medium">
                            <li class="pl-1">Ketik ID Akun.</li>
                            <li class="pl-1">Pilih Produk / Nominal.</li>
                            <li class="pl-1">Tentukan Pembayaran.</li>
                            <li class="pl-1">Bayar & Item langsung masuk!</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Main Section: Form Top Up -->
            <div class="w-full md:w-2/3 lg:w-3/4" x-data="{
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
                    <div class="bg-[#161920] rounded-2xl p-6 shadow-sm mb-6 border border-gray-800/80 transition-all focus-within:border-cyan-500/30 focus-within:ring-1 focus-within:ring-cyan-500/10">
                        <div class="flex items-center gap-3 mb-5 border-b border-gray-800/80 pb-4">
                            <span class="w-7 h-7 bg-cyan-500/10 text-cyan-400 rounded-lg flex items-center justify-center font-bold text-sm border border-cyan-500/20">1</span>
                            <h3 class="text-lg font-bold text-white tracking-wide">Data Akun</h3>
                        </div>
                        <div class="grid grid-cols-1 {{ $game->has_server_id ? 'md:grid-cols-2' : '' }} gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">User ID <span class="text-cyan-500">*</span></label>
                                <input type="text" x-model="userId" name="user_id_input" required class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all shadow-inner hover:border-gray-700" placeholder="Contoh: 12345678">
                            </div>
                            @if($game->has_server_id)
                            <div>
                                <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Server/Zone ID <span class="text-cyan-500">*</span></label>
                                <input type="text" x-model="serverId" name="server_id_input" required class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all shadow-inner hover:border-gray-700" placeholder="Contoh: 2021">
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Step 2: Nominal Top Up -->
                    <div class="bg-[#161920] rounded-2xl p-6 shadow-sm mb-6 border border-gray-800/80 transition-all">
                        <div class="flex items-center gap-3 mb-5 border-b border-gray-800/80 pb-4">
                            <span class="w-7 h-7 bg-cyan-500/10 text-cyan-400 rounded-lg flex items-center justify-center font-bold text-sm border border-cyan-500/20">2</span>
                            <h3 class="text-lg font-bold text-white tracking-wide">Pilih Produk</h3>
                        </div>
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse($game->products as $product)
                                <label class="cursor-pointer relative group">
                                    <input type="radio" class="hidden peer" name="product_id" value="{{ $product->id }}" @change="selectedProduct = {{ $product->price }}">
                                    <div class="h-full bg-[#1a1c22] border border-gray-800 rounded-xl p-5 text-center group-hover:border-cyan-500/40 peer-checked:border-cyan-400 peer-checked:bg-cyan-900/10 transition-all flex flex-col justify-center shadow-sm">
                                        <div class="absolute inset-0 bg-cyan-400 rounded-xl blur-[2px] opacity-0 peer-checked:opacity-20 transition-opacity -z-10"></div>
                                        <p class="font-bold text-white mb-1.5 leading-tight">{{ $product->name }}</p>
                                        <p class="text-sm font-medium text-gray-400 peer-checked:text-cyan-300 transition-colors">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="absolute top-2 right-2 text-cyan-400 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <svg class="w-5 h-5 bg-[#161920] rounded-full" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </label>
                            @empty
                                <p class="text-gray-500 italic text-sm col-span-full">Produk belum tersedia untuk game ini.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Step 3: Pembayaran -->
                    <div class="bg-[#161920] rounded-2xl p-6 shadow-sm mb-6 border border-gray-800/80 transition-all" x-cloak x-show="selectedProduct !== null">
                        <div class="flex items-center gap-3 mb-5 border-b border-gray-800/80 pb-4">
                            <span class="w-7 h-7 bg-cyan-500/10 text-cyan-400 rounded-lg flex items-center justify-center font-bold text-sm border border-cyan-500/20">3</span>
                            <h3 class="text-lg font-bold text-white tracking-wide">Metode Pembayaran</h3>
                        </div>
                        <div class="space-y-3">
                            @foreach($paymentMethods as $payment)
                                <label class="block cursor-pointer group">
                                    <input type="radio" class="hidden peer" name="payment_method_id" value="{{ $payment->id }}" @change="selectedPayment = {{ $payment->fee_flat }}">
                                    <div class="bg-[#1a1c22] border border-gray-800 rounded-xl p-4 flex justify-between items-center group-hover:border-cyan-500/40 peer-checked:border-cyan-400 peer-checked:bg-cyan-900/10 transition-all shadow-sm">
                                        <div>
                                            <p class="font-bold text-base text-gray-200 peer-checked:text-white transition-colors">
                                                {{ $payment->name }}
                                            </p>
                                            <p class="text-xs font-medium text-gray-500 mt-1">Biaya admin: Rp <span x-text="new Intl.NumberFormat('id-ID').format({{ $payment->fee_flat }})"></span></p>
                                        </div>
                                        <div class="text-right peer-checked:block hidden transition-all">
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-0.5">Total</p>
                                            <p class="text-cyan-400 font-bold text-lg leading-none tracking-tight" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedProduct + {{ $payment->fee_flat }})"></p>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Step 4: Kontak WhatsApp -->
                    <div class="bg-[#161920] rounded-2xl p-6 shadow-sm mb-8 border border-gray-800/80 transition-all focus-within:border-cyan-500/30 focus-within:ring-1 focus-within:ring-cyan-500/10">
                        <div class="flex items-center gap-3 mb-5 border-b border-gray-800/80 pb-4">
                            <span class="w-7 h-7 bg-cyan-500/10 text-cyan-400 rounded-lg flex items-center justify-center font-bold text-sm border border-cyan-500/20">4</span>
                            <h3 class="text-lg font-bold text-white tracking-wide">Detail Kontak</h3>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">No. Telepon / WhatsApp <span class="text-cyan-500">*</span></label>
                            <input type="number" x-model="phone" name="phone" required class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all shadow-inner hover:border-gray-700" placeholder="08123456789">
                            <p class="text-xs font-medium text-gray-500 mt-3 flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Bukti pembayaran akan dikirim ke nomor ini.</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" x-bind:disabled="!userId || !selectedProduct || !selectedPayment || !phone" class="w-full bg-cyan-600 hover:bg-cyan-500 disabled:bg-gray-800 disabled:text-gray-500 disabled:cursor-not-allowed text-white font-bold tracking-widest uppercase py-4 md:py-5 rounded-xl transition-all focus:outline-none focus:ring-4 focus:ring-cyan-500/30 shadow-lg hover:shadow-cyan-500/20 flex justify-center items-center gap-2">
                        <span>Lanjutkan Checkout</span>
                    </button>
                    <style>[x-cloak] { display: none !important; }</style>
                </form>
            </div>
        </div>
    </main>

    <footer class="mt-12 py-8 border-t border-gray-800/60 bg-[#111318] text-center text-gray-600 text-sm font-medium">
        <p>&copy; 2026 GameUp. Platform minimalis top up idaman gamers.</p>
    </footer>
</body>
</html>
