@extends('layouts.admin')

@section('title', 'Kelola Orders')

@section('content')
    <div class="mb-8">
        <p class="text-sm text-gray-400">{{ $orders->total() }} total pesanan</p>
    </div>

    <div class="bg-[#161920] rounded-2xl border border-gray-800/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800/80">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Invoice</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Game</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Produk</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">ID Pemain</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Total</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Bayar Via</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Waktu</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="border-b border-gray-800/40 hover:bg-[#1a1c22] transition-colors">
                        <td class="px-6 py-4 font-mono text-xs text-gray-300">{{ $order->invoice_number }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $order->game->name }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $order->product->name }}</td>
                        <td class="px-6 py-4 text-gray-400 font-mono text-xs">{{ $order->game_user_id }}</td>
                        <td class="px-6 py-4 font-bold text-white">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $order->paymentMethod->name }}</td>
                        <td class="px-6 py-4">
                            @if($order->status === 'UNPAID')
                                <span class="inline-block px-3 py-1 rounded-md text-[10px] font-bold bg-[#fcb045]/10 text-[#fcb045] border border-[#fcb045]/20 tracking-wider">UNPAID</span>
                            @elseif($order->status === 'SUCCESS')
                                <span class="inline-block px-3 py-1 rounded-md text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 tracking-wider">SUCCESS</span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-md text-[10px] font-bold bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 tracking-wider">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">{{ $order->created_at->format('d M H:i') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.detail', $order) }}" class="text-xs font-medium text-cyan-400 hover:text-cyan-300">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-10 text-center text-gray-500 italic">Belum ada pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endsection
