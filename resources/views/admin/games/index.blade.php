@extends('layouts.admin')

@section('title', 'Kelola Games')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <p class="text-sm text-gray-400">{{ $games->count() }} games terdaftar</p>
        <a href="{{ route('admin.games.create') }}" class="bg-cyan-600 hover:bg-cyan-500 text-white text-sm font-bold tracking-wider uppercase px-5 py-2.5 rounded-lg transition-all shadow-sm">
            + Tambah Game
        </a>
    </div>

    <div class="bg-[#161920] rounded-2xl border border-gray-800/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-800/80">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Game</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Slug</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Kategori</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Produk</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Server ID</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($games as $game)
                    <tr class="border-b border-gray-800/40 hover:bg-[#1a1c22] transition-colors">
                        <td class="px-6 py-4 font-bold text-white">{{ $game->name }}</td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-400">{{ $game->slug }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $game->category ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $game->products_count }}</td>
                        <td class="px-6 py-4">
                            @if($game->has_server_id)
                                <span class="text-emerald-400 text-xs font-bold">Ya</span>
                            @else
                                <span class="text-gray-500 text-xs font-bold">Tidak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.games.edit', $game) }}" class="text-xs font-medium text-cyan-400 hover:text-cyan-300">Edit</a>
                                <form action="{{ route('admin.games.delete', $game) }}" method="POST" onsubmit="return confirm('Hapus game ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-300">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">Belum ada game.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
