@extends('layouts.penjual')

@section('title', 'Dashboard Penjual - TukuSepatu')

@section('content')
<div class="space-y-6">

    {{-- ================= ALERT / NOTIFICATION ================= --}}
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

    {{-- ================= WELCOME HERO BANNER ================= --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-brand-900 text-white p-6 sm:p-8 shadow-xl border border-slate-700/50">
        {{-- Background decorative shapes --}}
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-brand-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -top-12 w-60 h-60 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="bg-brand-500/20 text-brand-300 font-bold px-3 py-1 rounded-full border border-brand-500/30">
                        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                    </span>
                    <span class="bg-emerald-500/20 text-emerald-300 font-bold px-3 py-1 rounded-full border border-emerald-500/30 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Performa Toko Maksimal
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Selamat Datang Kembali, <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-amber-300">{{ Auth::user()->nama_user }}</span>
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed">
                    Kelola produk sepatu, pantau transaksi pembeli, dan tingkatkan omzet tokomu dengan analitik real-time hari ini.
                </p>

                {{-- Metric Badges --}}
                <div class="pt-2 flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-300">
                    <div class="bg-slate-800/80 px-3 py-1.5 rounded-xl border border-slate-700/60">
                        <span>Respon Chat: <strong class="text-white">99% (Sangat Cepat)</strong></span>
                    </div>
                    <div class="bg-slate-800/80 px-3 py-1.5 rounded-xl border border-slate-700/60">
                        <span>Pengiriman: <strong class="text-white">99.2% Tepat Waktu</strong></span>
                    </div>
                </div>
            </div>

            {{-- Right Quick Actions --}}
            <div class="flex flex-col sm:flex-row lg:flex-col gap-3 flex-shrink-0">
                <a href="{{ route('penjual.produk') }}" 
                   class="inline-flex items-center justify-center bg-gradient-to-r from-brand-500 to-amber-500 hover:from-brand-600 hover:to-amber-600 text-white font-bold text-xs px-5 py-3 rounded-2xl shadow-lg shadow-brand-500/30 transition-all hover:scale-[1.02] active:scale-[0.98]">
                    <span>Tambah Produk Sepatu</span>
                </a>
                <a href="{{ route('penjual.pesanan') }}" 
                   class="inline-flex items-center justify-center bg-slate-800/90 hover:bg-slate-700 text-slate-200 font-bold text-xs px-5 py-3 rounded-2xl border border-slate-700/80 transition-all">
                    <span>Proses 5 Pesanan Baru</span>
                </a>
            </div>
        </div>
    </div>

    {{-- ================= STAT CARDS GRID ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        {{-- Card 1: Total Pendapatan --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-extrabold text-brand-600 bg-brand-50 px-3 py-1 rounded-xl border border-brand-100">OMZET</span>
                <span class="text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/60 px-2.5 py-1 rounded-full">
                    +18.4%
                </span>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">Rp 14.850.000</h3>
            <p class="text-[11px] text-slate-500 mt-2 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span> Terhitung bulan September 2026
            </p>
        </div>

        {{-- Card 2: Pesanan Masuk --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-extrabold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-xl border border-indigo-100">TRANSAKSI</span>
                <span class="text-[11px] font-bold bg-amber-50 text-amber-600 border border-amber-200/60 px-2.5 py-1 rounded-full">
                    5 Perlu Diproses
                </span>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pesanan Masuk</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">18 Pesanan</h3>
            <p class="text-[11px] text-slate-500 mt-2 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-indigo-500 inline-block"></span> 13 Pesanan telah dikirim
            </p>
        </div>

        {{-- Card 3: Total Produk --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-extrabold text-sky-600 bg-sky-50 px-3 py-1 rounded-xl border border-sky-100">KATALOG</span>
                <span class="text-[11px] font-bold bg-rose-50 text-rose-600 border border-rose-200/60 px-2.5 py-1 rounded-full">
                    2 Stok Menipis
                </span>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Katalog Produk</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">24 Sepatu</h3>
            <p class="text-[11px] text-slate-500 mt-2 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-sky-500 inline-block"></span> 22 Produk aktif dijual
            </p>
        </div>

        {{-- Card 4: Rating Toko --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-extrabold text-amber-600 bg-amber-50 px-3 py-1 rounded-xl border border-amber-100">REPUTASI</span>
                <span class="text-[11px] font-bold bg-amber-50 text-amber-600 border border-amber-200/60 px-2.5 py-1 rounded-full">
                    98.6% Puas
                </span>
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rating & Ulasan</p>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">4.9 <span class="text-sm font-normal text-slate-400">/ 5.0</span></h3>
            <p class="text-[11px] text-slate-500 mt-2 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span> Total 128 Ulasan Pembeli
            </p>
        </div>
    </div>

    {{-- ================= CHARTS & PIPELINE GRID ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Revenue Chart Card (2 Columns) --}}
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-extrabold text-lg text-slate-800">Grafik Penjualan & Omzet</h2>
                        <span class="text-[10px] bg-slate-100 font-bold text-slate-600 px-2.5 py-0.5 rounded-md">Realtime</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Tren pendapatan harian selama 7 hari terakhir</p>
                </div>

                <div class="flex items-center gap-1.5 bg-slate-100/80 p-1 rounded-xl border border-slate-200/60 self-start sm:self-auto text-xs font-semibold">
                    <button class="px-3 py-1.5 bg-white text-slate-800 rounded-lg shadow-sm font-bold">7 Hari</button>
                    <button class="px-3 py-1.5 text-slate-500 hover:text-slate-800 transition">30 Hari</button>
                    <button class="px-3 py-1.5 text-slate-500 hover:text-slate-800 transition">Bulan Ini</button>
                </div>
            </div>

            {{-- Chart canvas container --}}
            <div class="relative h-64 sm:h-72 w-full">
                <canvas id="salesChart"></canvas>
            </div>

            {{-- Chart Footer Breakdown --}}
            <div class="mt-6 pt-4 border-t border-slate-100 grid grid-cols-3 gap-4 text-center">
                <div class="border-r border-slate-100">
                    <p class="text-[11px] font-semibold text-slate-400">Puncak Omzet</p>
                    <p class="text-sm font-extrabold text-slate-800 mt-0.5">Rp 3.400.000</p>
                    <span class="text-[10px] text-emerald-500 font-semibold">Sabtu (26 Sep)</span>
                </div>
                <div class="border-r border-slate-100">
                    <p class="text-[11px] font-semibold text-slate-400">Rata-rata / Hari</p>
                    <p class="text-sm font-extrabold text-slate-800 mt-0.5">Rp 2.121.000</p>
                    <span class="text-[10px] text-slate-400 font-semibold">7 Hari Terakhir</span>
                </div>
                <div>
                    <p class="text-[11px] font-semibold text-slate-400">Estimasi Akhir Bulan</p>
                    <p class="text-sm font-extrabold text-brand-600 mt-0.5">Rp 22.500.000</p>
                    <span class="text-[10px] text-brand-500 font-semibold">Target Toko 85%</span>
                </div>
            </div>
        </div>

        {{-- Order Status Pipeline Card (1 Column) --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="font-extrabold text-lg text-slate-800">Status Pesanan</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Ringkasan status transaksi aktif</p>
                    </div>
                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">LIVE</span>
                </div>

                <div class="space-y-4 my-4">
                    {{-- Status Item 1: Perlu Diproses --}}
                    <div class="p-3.5 rounded-2xl bg-amber-50/60 border border-amber-200/50">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-bold text-amber-900 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                                Perlu Diproses (Siap Pack)
                            </span>
                            <span class="text-xs font-extrabold text-amber-700 bg-amber-200/60 px-2 py-0.5 rounded-md">5 Order</span>
                        </div>
                        <div class="w-full bg-amber-200/50 h-2 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-full rounded-full" style="width: 45%"></div>
                        </div>
                        <div class="flex justify-between items-center text-[11px] text-amber-700 font-medium mt-1.5">
                            <span>Estimasi Nilai: Rp 3.850.000</span>
                            <a href="{{ route('penjual.pesanan') }}" class="font-bold underline hover:text-amber-900">Proses &rarr;</a>
                        </div>
                    </div>

                    {{-- Status Item 2: Dalam Pengiriman --}}
                    <div class="p-3.5 rounded-2xl bg-sky-50/60 border border-sky-200/50">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-bold text-sky-900 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                                Dalam Pengiriman
                            </span>
                            <span class="text-xs font-extrabold text-sky-700 bg-sky-200/60 px-2 py-0.5 rounded-md">7 Order</span>
                        </div>
                        <div class="w-full bg-sky-200/50 h-2 rounded-full overflow-hidden">
                            <div class="bg-sky-500 h-full rounded-full" style="width: 65%"></div>
                        </div>
                        <div class="flex justify-between items-center text-[11px] text-sky-700 font-medium mt-1.5">
                            <span>Estimasi Nilai: Rp 5.200.000</span>
                            <a href="{{ route('penjual.pesanan') }}" class="font-bold underline hover:text-sky-900">Lacak &rarr;</a>
                        </div>
                    </div>

                    {{-- Status Item 3: Selesai --}}
                    <div class="p-3.5 rounded-2xl bg-emerald-50/60 border border-emerald-200/50">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-bold text-emerald-900 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                Pesanan Selesai
                            </span>
                            <span class="text-xs font-extrabold text-emerald-700 bg-emerald-200/60 px-2 py-0.5 rounded-md">6 Order</span>
                        </div>
                        <div class="w-full bg-emerald-200/50 h-2 rounded-full overflow-hidden">
                            <div class="bg-emerald-500 h-full rounded-full" style="width: 85%"></div>
                        </div>
                        <div class="flex justify-between items-center text-[11px] text-emerald-700 font-medium mt-1.5">
                            <span>Dana Berhasil Cair: Rp 5.800.000</span>
                            <span class="font-bold">Selesai</span>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('penjual.pesanan') }}" 
               class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-2xl text-center transition shadow-md block">
                Kelola Semua Pesanan
            </a>
        </div>
    </div>

    {{-- ================= TABLES GRID: PESANAN TERBARU & STOK WARNING ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Pesanan Terbaru Table (2 Columns) --}}
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <div>
                    <h2 class="font-extrabold text-lg text-slate-800">Pesanan Terbaru Masuk</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar transaksi pembeli yang membutuhkan respon kamu</p>
                </div>
                <a href="{{ route('penjual.pesanan') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700">
                    Lihat Semua &rarr;
                </a>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/80 rounded-xl">
                            <th class="py-3 px-4 rounded-l-xl">No. Pesanan</th>
                            <th class="py-3 px-4">Pembeli & Produk</th>
                            <th class="py-3 px-4">Total Bayar</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right rounded-r-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                        {{-- Row 1 --}}
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-800">#ORD-8921</span>
                                <span class="block text-[10px] text-slate-400">Hari ini, 13:20</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-700 font-extrabold text-xs flex items-center justify-center shadow-inner flex-shrink-0">
                                        NK
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 truncate max-w-[180px]">Nike Air Max 270 Black</p>
                                        <p class="text-[10px] text-slate-400">Budi Santoso · Size 42 (1x)</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                Rp 1.650.000
                                <span class="block text-[10px] text-emerald-600 font-normal">Lunas (QRIS)</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Perlu Diproses
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <button class="bg-brand-500 hover:bg-brand-600 text-white font-bold text-[11px] px-3 py-1.5 rounded-xl shadow-sm transition">
                                    Proses Kirim
                                </button>
                            </td>
                        </tr>

                        {{-- Row 2 --}}
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-800">#ORD-8920</span>
                                <span class="block text-[10px] text-slate-400">Hari ini, 11:05</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs flex items-center justify-center shadow-inner flex-shrink-0">
                                        AD
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 truncate max-w-[180px]">Adidas Ultraboost 5.0</p>
                                        <p class="text-[10px] text-slate-400">Siti Rahmawati · Size 39 (1x)</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                Rp 1.950.000
                                <span class="block text-[10px] text-emerald-600 font-normal">Lunas (Transfer)</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Perlu Diproses
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <button class="bg-brand-500 hover:bg-brand-600 text-white font-bold text-[11px] px-3 py-1.5 rounded-xl shadow-sm transition">
                                    Proses Kirim
                                </button>
                            </td>
                        </tr>

                        {{-- Row 3 --}}
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-800">#ORD-8918</span>
                                <span class="block text-[10px] text-slate-400">Kemarin, 19:40</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs flex items-center justify-center shadow-inner flex-shrink-0">
                                        PM
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 truncate max-w-[180px]">Puma RS-X Reinvent</p>
                                        <p class="text-[10px] text-slate-400">Ahmad Fauzi · Size 43 (1x)</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                Rp 1.250.000
                                <span class="block text-[10px] text-sky-600 font-normal">JNE Reguler (Resi Inputted)</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="bg-sky-100 text-sky-800 text-[10px] font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> Dikirim
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <button class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] px-3 py-1.5 rounded-xl transition">
                                    Lacak Resi
                                </button>
                            </td>
                        </tr>

                        {{-- Row 4 --}}
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-800">#ORD-8915</span>
                                <span class="block text-[10px] text-slate-400">26 Sep 2026</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs flex items-center justify-center shadow-inner flex-shrink-0">
                                        CV
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 truncate max-w-[180px]">Converse Chuck Taylor All Star</p>
                                        <p class="text-[10px] text-slate-400">Dewi Lestari · Size 38 (2x)</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                Rp 1.500.000
                                <span class="block text-[10px] text-emerald-600 font-normal">Dana Diterima</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-full inline-flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <button class="bg-slate-100 text-slate-400 font-bold text-[11px] px-3 py-1.5 rounded-xl cursor-default">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Low Stock & Best Seller Sidebar Widget (1 Column) --}}
        <div class="space-y-6">
            
            {{-- Low Stock Warning Box --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="font-extrabold text-sm text-slate-800">Peringatan Stok Menipis</h2>
                        <p class="text-[10px] text-slate-400">Segera restock sebelum kehabisan</p>
                    </div>
                    <span class="text-[10px] bg-rose-50 text-rose-600 font-bold px-2.5 py-0.5 rounded-full border border-rose-200">2 Item</span>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 font-extrabold text-xs text-slate-700 flex items-center justify-center shadow-sm">
                                VN
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Vans Old Skool Black</p>
                                <p class="text-[10px] text-slate-400">Size 41 · Sisa 2 pasang</p>
                            </div>
                        </div>
                        <a href="{{ route('penjual.produk') }}" class="text-xs font-bold text-rose-600 hover:underline">Tambah</a>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 font-extrabold text-xs text-slate-700 flex items-center justify-center shadow-sm">
                                JD
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Air Jordan 1 Low Retro</p>
                                <p class="text-[10px] text-slate-400">Size 42 · Sisa 1 pasang</p>
                            </div>
                        </div>
                        <a href="{{ route('penjual.produk') }}" class="text-xs font-bold text-rose-600 hover:underline">Tambah</a>
                    </div>
                </div>
            </div>

            {{-- Seller Pro Tips Box --}}
            <div class="bg-gradient-to-br from-brand-500 via-orange-500 to-amber-500 rounded-3xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                <div class="mb-3">
                    <h3 class="font-extrabold text-sm text-white">Tips Penjualan Super</h3>
                    <p class="text-[11px] text-orange-100">Tingkatkan konversi tokomu</p>
                </div>
                <ul class="text-xs text-white/90 space-y-2 font-medium">
                    <li class="flex items-start gap-2">
                        <span class="font-bold">•</span>
                        <span>Upload foto tampak samping, sol, & dus sepatu dengan jelas.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="font-bold">•</span>
                        <span>Proses pengiriman &lt; 24 jam untuk mendapatkan lencana <strong>Sangat Cepat</strong>.</span>
                    </li>
                </ul>
                <button class="mt-4 w-full py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white font-bold text-xs rounded-xl transition border border-white/30">
                    Pelajari Panduan Seller &rarr;
                </button>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');

        // Gradient for chart area fill
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(234, 88, 12, 0.35)');
        gradient.addColorStop(1, 'rgba(234, 88, 12, 0.0)');

        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['22 Sep', '23 Sep', '24 Sep', '25 Sep', '26 Sep', '27 Sep', '28 Sep'],
                datasets: [{
                    label: 'Omzet Penjualan (Rp)',
                    data: [1200000, 1850000, 1400000, 2600000, 3400000, 2150000, 2250000],
                    borderColor: '#ea580c',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#ea580c',
                    pointBorderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return ' Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 11 },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        grid: {
                            color: '#f1f5f9',
                            borderDash: [4, 4]
                        },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 11 },
                            color: '#94a3b8',
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000) + ' Jt';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush