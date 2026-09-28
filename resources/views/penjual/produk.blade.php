@extends('layouts.penjual')

@section('title', 'Katalog Produk - TukuSepatu Seller Hub')

@section('content')
<div class="space-y-6">

    {{-- Notification Alert --}}
    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 px-5 py-4 rounded-2xl flex items-center justify-between shadow-sm">
            <div>
                <h4 class="font-bold text-sm text-emerald-900">Berhasil!</h4>
                <p class="text-xs text-emerald-700">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-xs font-bold text-emerald-700 hover:underline">
                Tutup
            </button>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Katalog Produk Sepatu</h1>
            <p class="text-xs text-slate-400 mt-0.5">Kelola stok, harga, dan varian sepatu di tokomu</p>
        </div>
        <a href="{{ route('penjual.produk.create') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-700 hover:to-amber-600 text-white font-bold text-xs px-5 py-3 rounded-xl shadow-md shadow-brand-500/20 transition">
            <span>+ Tambah Produk Baru</span>
        </a>
    </div>

    {{-- Filter & Search Form --}}
    <form action="{{ route('penjual.produk') }}" method="GET" class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/80 flex flex-col md:flex-row gap-3 justify-between items-center text-xs">
        <div class="relative w-full md:w-80">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama sepatu..." class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20">
        </div>
        <div class="flex items-center gap-2 w-full md:w-auto">
            <select name="kategori" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-700 focus:outline-none">
                <option value="Semua Kategori">Semua Kategori</option>
                @foreach(['Sneakers', 'Running', 'Casual', 'Formal', 'Boots', 'Sport'] as $cat)
                    <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl font-bold">Cari</button>
            @if(request('search') || request('kategori'))
                <a href="{{ route('penjual.produk') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold">Reset</a>
            @endif
        </div>
    </form>

    {{-- Product Grid --}}
    @if(isset($produks) && count($produks) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($produks as $p)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200/80 hover:shadow-md transition group flex flex-col justify-between">
                    <div>
                        <div class="h-44 bg-slate-100 flex items-center justify-center relative p-4 overflow-hidden">
                            @if($p->gambar_product)
                                <img src="{{ asset('storage/' . $p->gambar_product) }}" alt="{{ $p->nama_product }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <span class="text-2xl font-black text-slate-400 group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($p->nama_product, 0, 2)) }}
                                </span>
                            @endif

                            <span class="absolute top-3 left-3 text-[10px] font-bold {{ $p->status_product === 'habis' || $p->stok <= 2 ? 'bg-rose-100 text-rose-700 border-rose-200' : 'bg-emerald-100 text-emerald-700 border-emerald-200' }} border px-2.5 py-0.5 rounded-full">
                                {{ $p->status_product === 'habis' ? 'Habis' : ($p->stok <= 2 ? 'Stok Menipis' : 'Tersedia') }}
                            </span>
                            <span class="absolute top-3 right-3 text-[10px] font-bold bg-white/90 backdrop-blur-sm text-slate-600 px-2 py-0.5 rounded-md border border-slate-200">
                                {{ $p->kategori ?? 'Umum' }}
                            </span>
                        </div>

                        <div class="p-4 space-y-2">
                            <h3 class="font-extrabold text-xs text-slate-800 line-clamp-1" title="{{ $p->nama_product }}">{{ $p->nama_product }}</h3>
                            <p class="text-sm font-extrabold text-brand-600">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>

                            <div class="flex items-center justify-between text-[11px] text-slate-500 pt-2 border-t border-slate-100">
                                <span>Stok: <strong class="{{ $p->stok <= 2 ? 'text-rose-600' : 'text-slate-800' }}">{{ $p->stok }} pasang</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 pt-0 grid grid-cols-2 gap-2">
                        <a href="{{ route('penjual.produk.edit', $p->id_product) }}" class="py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] rounded-xl text-center transition">
                            Edit
                        </a>
                        <form action="{{ route('penjual.produk.destroy', $p->id_product) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[11px] rounded-xl transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-sm space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-600 font-black text-2xl flex items-center justify-center mx-auto shadow-inner">
                TS
            </div>
            <div>
                <h3 class="font-extrabold text-slate-800 text-base">Belum Ada Produk Sepatu</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Mulai tambahkan produk sepatu pertama milikmu untuk dijual di toko online TukuSepatu!</p>
            </div>
            <a href="{{ route('penjual.produk.create') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-brand-600 to-amber-500 text-white font-bold text-xs rounded-xl shadow-md transition">
                + Tambah Produk Pertama
            </a>
        </div>
    @endif
</div>
@endsection