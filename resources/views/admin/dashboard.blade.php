@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-10">
        <div class="bg-[#161920] rounded-2xl p-6 border border-gray-800/80 shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Total Revenue</p>
            <p class="text-2xl lg:text-3xl font-extrabold text-white tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-xs text-emerald-400 font-medium mt-2">dari {{ $successOrders }} transaksi sukses</p>
        </div>
        <div class="bg-[#161920] rounded-2xl p-6 border border-gray-800/80 shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Total Orders</p>
            <p class="text-2xl lg:text-3xl font-extrabold text-white tracking-tight">{{ $totalOrders }}</p>
            <p class="text-xs text-gray-500 font-medium mt-2">semua pesanan masuk</p>
        </div>
        <div class="bg-[#161920] rounded-2xl p-6 border border-gray-800/80 shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Menunggu Bayar</p>
            <p class="text-2xl lg:text-3xl font-extrabold text-[#fcb045] tracking-tight">{{ $pendingOrders }}</p>
            <p class="text-xs text-gray-500 font-medium mt-2">belum terverifikasi</p>
        </div>
        <div class="bg-[#161920] rounded-2xl p-6 border border-gray-800/80 shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2">Katalog</p>
            <p class="text-2xl lg:text-3xl font-extrabold text-white tracking-tight">{{ $totalGames }}</p>
            <p class="text-xs text-gray-500 font-medium mt-2">games / {{ $totalProducts }} produk</p>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-[#161920] rounded-2xl border border-gray-800/80 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-800/80">
            <h2 class="font-bold text-white tracking-wide">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders') }}" class="text-xs font-medium text-cyan-400 hover:text-cyan-300 uppercase tracking-widest">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800/80">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Invoice</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Game</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Produk</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Total</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr class="border-b border-gray-800/40 hover:bg-[#1a1c22] transition-colors">
                        <td class="px-6 py-4 font-mono text-xs text-gray-300">{{ $order->invoice_number }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $order->game->name }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $order->product->name }}</td>
                        <td class="px-6 py-4 font-bold text-white">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($order->status === 'UNPAID')
                                <span class="inline-block px-3 py-1 rounded-md text-[10px] font-bold bg-[#fcb045]/10 text-[#fcb045] border border-[#fcb045]/20 tracking-wider">UNPAID</span>
                            @elseif($order->status === 'SUCCESS')
                                <span class="inline-block px-3 py-1 rounded-md text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 tracking-wider">SUCCESS</span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-md text-[10px] font-bold bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 tracking-wider">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">Belum ada pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
