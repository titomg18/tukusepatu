@extends('layouts.penjual')

@section('title', 'Tambah Produk Baru - TukuSepatu Seller Hub')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Tambah Produk Sepatu Baru</h1>
            <p class="text-xs text-slate-400 mt-0.5">Isi rincian informasi produk sepatu yang ingin kamu jual di toko</p>
        </div>
        <a href="{{ route('penjual.produk') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
            Kembali ke Katalog
        </a>
    </div>

    {{-- Error summary alert --}}
    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl text-xs space-y-1">
            <p class="font-bold text-sm text-rose-800">Terdapat kesalahan pada inputan formulir:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('penjual.produk.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-6">
        @csrf

        {{-- Nama Produk --}}
        <div>
            <label for="nama_product" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Nama Produk Sepatu <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="nama_product" id="nama_product" value="{{ old('nama_product') }}" required
                   placeholder="Contoh: Nike Air Max 270 Black Red"
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
            @error('nama_product')
                <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kategori & Status --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="kategori" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Kategori <span class="text-rose-500">*</span>
                </label>
                <select name="kategori" id="kategori" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Sneakers" {{ old('kategori') == 'Sneakers' ? 'selected' : '' }}>Sneakers</option>
                    <option value="Running" {{ old('kategori') == 'Running' ? 'selected' : '' }}>Running</option>
                    <option value="Casual" {{ old('kategori') == 'Casual' ? 'selected' : '' }}>Casual</option>
                    <option value="Formal" {{ old('kategori') == 'Formal' ? 'selected' : '' }}>Formal</option>
                    <option value="Boots" {{ old('kategori') == 'Boots' ? 'selected' : '' }}>Boots</option>
                    <option value="Sport" {{ old('kategori') == 'Sport' ? 'selected' : '' }}>Sport</option>
                </select>
                @error('kategori')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status_product" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Status Produk <span class="text-rose-500">*</span>
                </label>
                <select name="status_product" id="status_product" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    <option value="tersedia" {{ old('status_product') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis" {{ old('status_product') == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
                @error('status_product')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Harga & Stok --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="harga" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Harga (Rp) <span class="text-rose-500">*</span>
                </label>
                <input type="number" name="harga" id="harga" value="{{ old('harga') }}" min="0" required
                       placeholder="Contoh: 1250000"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('harga')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stok" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Jumlah Stok (Pasang) <span class="text-rose-500">*</span>
                </label>
                <input type="number" name="stok" id="stok" value="{{ old('stok', 10) }}" min="0" required
                       placeholder="Contoh: 15"
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('stok')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Gambar Produk --}}
        <div>
            <label for="gambar_product" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Foto / Gambar Produk Sepatu
            </label>
            <input type="file" name="gambar_product" id="gambar_product" accept="image/*"
                   class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 focus:outline-none focus:border-brand-500 transition">
            <p class="text-[11px] text-slate-400 mt-1">Format yang didukung: JPG, PNG, WEBP (Maksimal 2MB)</p>
            @error('gambar_product')
                <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Deskripsi Produk
            </label>
            <textarea name="deskripsi" id="deskripsi" rows="4"
                      placeholder="Jelaskan spesifikasi bahan sepatu, ukuran (size chart), dan kondisi..."
                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('penjual.produk') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-700 hover:to-amber-600 text-white font-bold text-xs rounded-xl shadow-md shadow-brand-500/20 transition">
                Simpan Produk Baru
            </button>
        </div>
    </form>
</div>
@endsection
