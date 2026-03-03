@extends('layouts.admin')

@section('title', isset($method) ? 'Edit Metode Pembayaran' : 'Tambah Metode Pembayaran')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.payment-methods') }}" class="text-sm font-medium text-gray-400 hover:text-cyan-400 transition-colors flex items-center gap-2 w-fit mb-8">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>

        <form action="{{ isset($method) ? route('admin.payment-methods.update', $method) : route('admin.payment-methods.store') }}" method="POST">
            @csrf
            @if(isset($method)) @method('PUT') @endif

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
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Nama <span class="text-cyan-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $method->name ?? '') }}" required class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700" placeholder="QRIS">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Kode <span class="text-cyan-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code', $method->code ?? '') }}" required class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700" placeholder="QRIS">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Fee Flat (Rp) <span class="text-cyan-500">*</span></label>
                        <input type="number" name="fee_flat" value="{{ old('fee_flat', $method->fee_flat ?? 0) }}" required min="0" class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700" placeholder="1000">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Fee Persen (%)</label>
                        <input type="number" name="fee_percent" value="{{ old('fee_percent', $method->fee_percent ?? 0) }}" min="0" max="100" step="0.1" class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700" placeholder="0">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Instruksi Pembayaran</label>
                    <textarea name="instructions" rows="3" class="w-full bg-[#1a1c22] border border-gray-800 rounded-xl px-4 py-3.5 focus:outline-none focus:border-cyan-500/50 focus:ring-1 focus:ring-cyan-500/50 text-white placeholder-gray-600 font-medium transition-all hover:border-gray-700 resize-none" placeholder="Instruksi pembayaran untuk customer...">{{ old('instructions', $method->instructions ?? '') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold tracking-widest uppercase py-3.5 rounded-xl transition-all focus:outline-none focus:ring-4 focus:ring-cyan-500/30 shadow-lg hover:shadow-cyan-500/20 text-sm">
                    {{ isset($method) ? 'Simpan Perubahan' : 'Tambah Metode' }}
                </button>
            </div>
        </form>
    </div>
@endsection
