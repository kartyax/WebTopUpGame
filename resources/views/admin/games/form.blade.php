@extends('layouts.admin')

@section('title', isset($game) ? 'Edit Game' : 'Tambah Game')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.games') }}" class="text-sm font-medium text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2 w-fit mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Game
        </a>

        <form action="{{ isset($game) ? route('admin.games.update', $game) : route('admin.games.store') }}" method="POST">
            @csrf
            @if(isset($game)) @method('PUT') @endif

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
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Nama Game <span class="text-cyan-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $game->name ?? '') }}" required class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700" placeholder="Mobile Legends">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Slug <span class="text-cyan-500">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug', $game->slug ?? '') }}" required class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700" placeholder="mobile-legends">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Kategori</label>
                    <input type="text" name="category" value="{{ old('category', $game->category ?? '') }}" class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700" placeholder="Mobile Game">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700 resize-none" placeholder="Deskripsi singkat game...">{{ old('description', $game->description ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Image URL</label>
                    <input type="url" name="image_url" value="{{ old('image_url', $game->image_url ?? '') }}" class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700" placeholder="https://example.com/image.png">
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="has_server_id" id="has_server_id" value="1" {{ old('has_server_id', $game->has_server_id ?? false) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-700 bg-[#1a1c22] text-cyan-500 focus:ring-cyan-500/50">
                    <label for="has_server_id" class="text-sm font-medium text-gray-300">Game ini memerlukan Server/Zone ID</label>
                </div>

                <button type="submit" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold tracking-widest uppercase py-3.5 rounded-xl transition-all focus:outline-none focus:ring-4 focus:ring-cyan-500/30 shadow-lg hover:shadow-cyan-500/20 text-sm">
                    {{ isset($game) ? 'Simpan Perubahan' : 'Tambah Game' }}
                </button>
            </div>
        </form>
    </div>
@endsection
