@extends('layouts.admin')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.products') }}" class="text-sm font-medium text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2 w-fit mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Produk
        </a>

        <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST">
            @csrf
            @if(isset($product)) @method('PUT') @endif

            <div class="bg-[#161920] rounded-2xl p-6 md:p-8 border border-gray-800/80 shadow-sm space-y-6">
                @if($errors->any())
                <div class="bg-red-500/10 text-red-400 border border-red-500/30 p-4 rounded-xl text-sm font-medium">
                    <ul class="list-disc ml-4 space-y-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Game <span class="text-cyan-500">*</span></label>
                    <select name="game_id" required class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white font-medium transition-all hover:border-gray-700">
                        <option value="" class="text-gray-500">-- Pilih Game --</option>
                        @foreach($games as $game)
                        <option value="{{ $game->id }}" {{ old('game_id', $product->game_id ?? '') == $game->id ? 'selected' : '' }}>{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Nama Produk <span class="text-cyan-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700" placeholder="86 Diamonds">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Harga (Rp) <span class="text-cyan-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required min="0" class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700" placeholder="20000">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Kode Provider</label>
                    <input type="text" name="provider_code" value="{{ old('provider_code', $product->provider_code ?? '') }}" class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700" placeholder="ml-86-dm">
                </div>

                <button type="submit" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold tracking-widest uppercase py-3.5 rounded-xl transition-all focus:outline-none focus:ring-4 focus:ring-cyan-500/30 shadow-lg hover:shadow-cyan-500/20 text-sm">
                    {{ isset($product) ? 'Simpan Perubahan' : 'Tambah Produk' }}
                </button>
            </div>
        </form>
    </div>
@endsection
