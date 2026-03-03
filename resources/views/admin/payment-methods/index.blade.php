@extends('layouts.admin')

@section('title', 'Metode Pembayaran')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <p class="text-sm text-gray-400">{{ $methods->count() }} metode terdaftar</p>
        <a href="{{ route('admin.payment-methods.create') }}" class="bg-cyan-600 hover:bg-cyan-500 text-white text-sm font-bold tracking-wider uppercase px-5 py-2.5 rounded-lg transition-all shadow-sm">
            + Tambah Metode
        </a>
    </div>

    <div class="bg-[#161920] rounded-2xl border border-gray-800/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800/80">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Nama</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Kode</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Fee Flat</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Fee %</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($methods as $method)
                    <tr class="border-b border-gray-800/40 hover:bg-[#1a1c22] transition-colors">
                        <td class="px-6 py-4 font-bold text-white">{{ $method->name }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-400">{{ $method->code }}</td>
                        <td class="px-6 py-4 text-gray-300">Rp {{ number_format($method->fee_flat, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $method->fee_percent ?? 0 }}%</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.payment-methods.edit', $method) }}" class="text-xs font-medium text-cyan-400 hover:text-cyan-300">Edit</a>
                                <form action="{{ route('admin.payment-methods.delete', $method) }}" method="POST" onsubmit="return confirm('Hapus metode ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-300">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">Belum ada metode pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
