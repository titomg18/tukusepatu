@extends('layouts.pembeli')

@section('title', 'TukuSepatu - Katalog Sepatu Pilihan')

@section('content')
<div class="space-y-8">

    {{-- Welcome Hero Banner --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-brand-900 text-white p-6 sm:p-10 shadow-xl border border-slate-700/50">
        <div class="relative z-10 space-y-3 max-w-2xl">
            <span class="bg-brand-500/20 text-brand-300 font-bold px-3 py-1 rounded-full border border-brand-500/30 text-xs inline-block">
                Koleksi Terlengkap & Original
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white">
                @auth
                    Halo {{ Auth::user()->nama_user }}, Temukan Sepatu Impianmu
                @else
                    Selamat Datang di TukuSepatu, Temukan Sepatu Impianmu
                @endauth
            </h1>
            <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                Pilih berbagai koleksi sepatu sneakers, running, formal, dan kasual berkualitas terbaik dari penjual terpercaya di seluruh Indonesia.
            </p>
        </div>
    </div>

    {{-- Filter & Search Form --}}
    <form action="{{ route('pembeli.dashboard') }}" method="GET" class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/80 flex flex-col md:flex-row gap-3 justify-between items-center text-xs">
        <div class="relative w-full md:w-96">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama sepatu favoritmu..." 
                   class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20 text-xs font-medium">
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto">
            <select name="kategori" onchange="this.form.submit()" class="py-2.5 px-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-700 focus:outline-none">
                <option value="Semua Kategori">Semua Kategori</option>
                @foreach(['Sneakers', 'Running', 'Casual', 'Formal', 'Boots', 'Sport'] as $cat)
                    <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold transition">
                Cari
            </button>
            @if(request('search') || request('kategori'))
                <a href="{{ route('pembeli.dashboard') }}" class="px-3 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Products Grid --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-extrabold text-slate-900">Daftar Sepatu Terbaru</h2>
            <span class="text-xs text-slate-400 font-semibold">{{ count($produks) }} Produk Ditemukan</span>
        </div>

        @if(count($produks) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($produks as $p)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200/80 hover:shadow-md transition group flex flex-col justify-between">
                        <div>
                            {{-- Product Image / Badge --}}
                            <a href="{{ route('pembeli.produk.detail', $p->id_product) }}" class="h-48 bg-slate-100 flex items-center justify-center relative p-4 overflow-hidden block">
                                @if($p->gambar_product)
                                    <img src="{{ asset('storage/' . $p->gambar_product) }}" alt="{{ $p->nama_product }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <span class="text-3xl font-black text-slate-400 group-hover:scale-110 transition-transform">
                                        {{ strtoupper(substr($p->nama_product, 0, 2)) }}
                                    </span>
                                @endif

                                <span class="absolute top-3 left-3 text-[10px] font-bold {{ $p->status_product === 'habis' || $p->stok < 1 ? 'bg-rose-100 text-rose-700 border-rose-200' : 'bg-emerald-100 text-emerald-700 border-emerald-200' }} border px-2.5 py-0.5 rounded-full">
                                    {{ $p->status_product === 'habis' || $p->stok < 1 ? 'Stok Habis' : 'Tersedia' }}
                                </span>
                                <span class="absolute top-3 right-3 text-[10px] font-bold bg-white/90 backdrop-blur-sm text-slate-700 px-2 py-0.5 rounded-md border border-slate-200">
                                    {{ $p->kategori ?? 'Umum' }}
                                </span>
                            </a>

                            {{-- Product Info --}}
                            <div class="p-4 space-y-2">
                                <a href="{{ route('pembeli.produk.detail', $p->id_product) }}" class="block group-hover:text-brand-600 transition-colors">
                                    <h3 class="font-extrabold text-sm text-slate-800 line-clamp-1" title="{{ $p->nama_product }}">
                                        {{ $p->nama_product }}
                                    </h3>
                                </a>
                                <p class="text-xs text-slate-400 line-clamp-2">{{ $p->deskripsi ?? 'Sepatu berkualitas tinggi nyaman dipakai sehari-hari.' }}</p>

                                <div class="pt-2 flex items-center justify-between">
                                    <span class="text-base font-extrabold text-brand-600">
                                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[11px] text-slate-400 font-semibold">
                                        Sisa: {{ $p->stok }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="p-4 pt-0 space-y-2">
                            <a href="{{ route('pembeli.produk.detail', $p->id_product) }}" class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition flex items-center justify-center">
                                Lihat Detail Produk
                            </a>
                            @if($p->status_product !== 'habis' && $p->stok > 0)
                                <form action="{{ route('pembeli.keranjang.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_product" value="{{ $p->id_product }}">
                                    <button type="submit" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center justify-center">
                                        + Tambahkan ke Keranjang
                                    </button>
                                </form>
                            @else
                                <button disabled class="w-full py-2.5 bg-slate-100 text-slate-400 font-bold text-xs rounded-xl cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-500 font-black text-xl flex items-center justify-center mx-auto">
                    TS
                </div>
                <h3 class="font-extrabold text-slate-800 text-base">Tidak Ada Produk Ditemukan</h3>
                <p class="text-xs text-slate-400 max-w-sm mx-auto">Coba cari dengan kata kunci lain atau pilih kategori sepatu yang tersedia.</p>
            </div>
        @endif
    </div>

</div>
@endsection