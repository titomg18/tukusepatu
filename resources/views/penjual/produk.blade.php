@extends('layouts.penjual')

@section('title', 'Katalog Produk - TukuSepatu Seller Hub')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Katalog Produk Sepatu</h1>
            <p class="text-xs text-slate-400 mt-0.5">Kelola stok, harga, dan varian sepatu di tokomu</p>
        </div>
        <a href="#" class="inline-flex items-center gap-2 bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-700 hover:to-amber-600 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md shadow-brand-500/20 transition">
            <span>Tambah Produk Baru</span>
        </a>
    </div>

    {{-- Filter bar --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/80 flex flex-col md:flex-row gap-3 justify-between items-center text-xs">
        <div class="relative w-full md:w-80">
            <input type="text" placeholder="Cari berdasarkan nama sepatu..." class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/20">
        </div>
        <div class="flex items-center gap-2 w-full md:w-auto">
            <select class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-700 focus:outline-none">
                <option>Semua Kategori</option>
                <option>Sneakers</option>
                <option>Running</option>
                <option>Formal</option>
                <option>Boots</option>
            </select>
            <select class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-700 focus:outline-none">
                <option>Urutkan: Terbaru</option>
                <option>Stok Terbanyak</option>
                <option>Penjualan Tertinggi</option>
            </select>
        </div>
    </div>

    {{-- Product Grid Preview --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @php
            $sampleProducts = [
                ['kode' => 'NK-270', 'nama' => 'Nike Air Max 270 Black Red', 'harga' => 1650000, 'stok' => 14, 'terjual' => 42, 'kategori' => 'Sneakers', 'status' => 'Aktif'],
                ['kode' => 'AD-UB5', 'nama' => 'Adidas Ultraboost 5.0 Triple White', 'harga' => 1950000, 'stok' => 8, 'terjual' => 38, 'kategori' => 'Running', 'status' => 'Aktif'],
                ['kode' => 'PM-RSX', 'nama' => 'Puma RS-X Reinvent Grey', 'harga' => 1250000, 'stok' => 12, 'terjual' => 29, 'kategori' => 'Casual', 'status' => 'Aktif'],
                ['kode' => 'CV-CTH', 'nama' => 'Converse Chuck Taylor High', 'harga' => 850000, 'stok' => 20, 'terjual' => 64, 'kategori' => 'Canvas', 'status' => 'Aktif'],
                ['kode' => 'VN-OSK', 'nama' => 'Vans Old Skool Primary Check', 'harga' => 990000, 'stok' => 2, 'terjual' => 51, 'kategori' => 'Skate', 'status' => 'Stok Menipis'],
                ['kode' => 'AJ-1LG', 'nama' => 'Air Jordan 1 Low Golf White', 'harga' => 2450000, 'stok' => 1, 'terjual' => 18, 'kategori' => 'Basketball', 'status' => 'Stok Menipis'],
            ];
        @endphp

        @foreach($sampleProducts as $p)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200/80 hover:shadow-md transition group flex flex-col justify-between">
                <div>
                    <div class="h-44 bg-slate-100 flex items-center justify-center relative p-4">
                        <span class="text-2xl font-black text-slate-400 group-hover:scale-110 transition-transform">{{ $p['kode'] }}</span>
                        <span class="absolute top-3 left-3 text-[10px] font-bold {{ $p['status'] === 'Stok Menipis' ? 'bg-rose-100 text-rose-700 border-rose-200' : 'bg-emerald-100 text-emerald-700 border-emerald-200' }} border px-2.5 py-0.5 rounded-full">
                            {{ $p['status'] }}
                        </span>
                        <span class="absolute top-3 right-3 text-[10px] font-bold bg-white/90 backdrop-blur-sm text-slate-600 px-2 py-0.5 rounded-md border border-slate-200">
                            {{ $p['kategori'] }}
                        </span>
                    </div>

                    <div class="p-4 space-y-2">
                        <h3 class="font-extrabold text-xs text-slate-800 line-clamp-1" title="{{ $p['nama'] }}">{{ $p['nama'] }}</h3>
                        <p class="text-sm font-extrabold text-brand-600">Rp {{ number_format($p['harga'], 0, ',', '.') }}</p>

                        <div class="flex items-center justify-between text-[11px] text-slate-500 pt-2 border-t border-slate-100">
                            <span>Stok: <strong class="{{ $p['stok'] <= 2 ? 'text-rose-600' : 'text-slate-800' }}">{{ $p['stok'] }} pasang</strong></span>
                            <span>Terjual: <strong class="text-slate-800">{{ $p['terjual'] }}</strong></span>
                        </div>
                    </div>
                </div>

                <div class="p-4 pt-0 grid grid-cols-2 gap-2">
                    <button class="py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] rounded-xl transition">
                        Edit
                    </button>
                    <button class="py-2 bg-brand-50 hover:bg-brand-100 text-brand-600 font-bold text-[11px] rounded-xl transition">
                        Detail
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection