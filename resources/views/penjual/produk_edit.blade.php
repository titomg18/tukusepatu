@extends('layouts.penjual')

@section('title', 'Edit Produk - TukuSepatu Seller Hub')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Edit Produk Sepatu</h1>
            <p class="text-xs text-slate-400 mt-0.5">Perbarui informasi harga, stok, atau gambar produk</p>
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
    <form action="{{ route('penjual.produk.update', $produk->id_product) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-6">
        @csrf
        @method('PUT')

        {{-- Nama Produk --}}
        <div>
            <label for="nama_product" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Nama Produk Sepatu <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="nama_product" id="nama_product" value="{{ old('nama_product', $produk->nama_product) }}" required
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
                    @foreach(['Sneakers', 'Running', 'Casual', 'Formal', 'Boots', 'Sport'] as $cat)
                        <option value="{{ $cat }}" {{ old('kategori', $produk->kategori) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
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
                    <option value="tersedia" {{ old('status_product', $produk->status_product) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis" {{ old('status_product', $produk->status_product) == 'habis' ? 'selected' : '' }}>Habis</option>
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
                <input type="number" name="harga" id="harga" value="{{ old('harga', $produk->harga) }}" min="0" required
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('harga')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stok" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Jumlah Stok (Pasang) <span class="text-rose-500">*</span>
                </label>
                <input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" min="0" required
                       class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                @error('stok')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Gambar Produk --}}
        <div>
            <label for="gambar_product" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Ganti Gambar Produk (Opsional)
            </label>
            @if($produk->gambar_product)
                <div class="mb-3 flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <img src="{{ asset('storage/' . $produk->gambar_product) }}" alt="{{ $produk->nama_product }}" class="w-14 h-14 object-cover rounded-lg border">
                    <p class="text-xs text-slate-500">Gambar saat ini terpasang</p>
                </div>
            @endif
            <input type="file" name="gambar_product" id="gambar_product" accept="image/*"
                   class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 focus:outline-none focus:border-brand-500 transition">
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
                      class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
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
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
