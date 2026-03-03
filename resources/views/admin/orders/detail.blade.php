@extends('layouts.admin')

@section('title', 'Detail Order')

@section('content')
    <a href="{{ route('admin.orders') }}" class="text-sm font-medium text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2 w-fit mb-8">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Pesanan
    </a>

    <div class="max-w-4xl">
        <div class="bg-[#161920] rounded-2xl p-6 md:p-8 border border-gray-800/80 shadow-sm mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 pb-6 border-b border-gray-800/80">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Invoice</p>
                    <p class="text-xl font-bold font-mono text-white">{{ $order->invoice_number }}</p>
                </div>
                <div class="mt-3 sm:mt-0">
                    @if($order->status === 'UNPAID')
                        <span class="inline-block px-5 py-1.5 rounded-lg text-xs font-bold bg-[#fcb045]/10 text-[#fcb045] border border-[#fcb045]/20 tracking-wide">BELUM DIBAYAR</span>
                    @elseif($order->status === 'SUCCESS')
                        <span class="inline-block px-5 py-1.5 rounded-lg text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 tracking-wide">BERHASIL</span>
                    @else
                        <span class="inline-block px-5 py-1.5 rounded-lg text-xs font-bold bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 tracking-wide">{{ $order->status }}</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-5">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Game</p>
                        <p class="font-bold text-gray-200">{{ $order->game->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Produk</p>
                        <p class="font-bold text-gray-200">{{ $order->product->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">ID Pemain</p>
                        <p class="font-bold text-gray-200">
                            {{ $order->game_user_id }}
                            @if($order->game_server_id) <span class="text-gray-500">({{ $order->game_server_id }})</span> @endif
                        </p>
                    </div>
                </div>
                <div class="space-y-5">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Metode Bayar</p>
                        <p class="font-bold text-gray-200">{{ $order->paymentMethod->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">No. Telepon</p>
                        <p class="font-bold text-gray-200">{{ $order->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Waktu Transaksi</p>
                        <p class="font-bold text-gray-200">{{ $order->created_at->format('d M Y, H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-[#161920] rounded-2xl p-6 md:p-8 border border-gray-800/80 shadow-sm">
            <div class="flex justify-between items-center mb-3 text-gray-400 font-medium">
                <span class="text-sm">Harga Pembelian</span>
                <span>Rp {{ number_format($order->original_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center mb-3 text-gray-400 font-medium">
                <span class="text-sm">Biaya Admin</span>
                <span>Rp {{ number_format($order->fee, 0, ',', '.') }}</span>
            </div>
            <div class="border-t border-gray-800/80 mt-5 pt-5 flex justify-between items-center">
                <span class="font-bold text-gray-300 text-lg uppercase tracking-wider">Total</span>
                <span class="font-bold text-2xl text-cyan-400 tracking-tight">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
@endsection
