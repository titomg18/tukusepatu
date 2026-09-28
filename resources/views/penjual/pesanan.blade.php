@extends('layouts.penjual')

@section('title', 'Pesanan Masuk - TukuSepatu Seller Hub')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Kelola Pesanan Masuk</h1>
            <p class="text-xs text-slate-400 mt-0.5">Pantau status pesanan, cetak label pengiriman, dan input resi</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-4 py-2.5 rounded-xl transition">
                <span>Export Laporan</span>
            </button>
        </div>
    </div>

    {{-- Tabs status --}}
    <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-200/80 flex flex-wrap gap-1 text-xs font-bold">
        <button class="px-4 py-2 bg-brand-500 text-white rounded-xl shadow-sm">Semua (18)</button>
        <button class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl transition flex items-center gap-1.5">
            <span>Perlu Diproses</span>
            <span class="bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded-md text-[10px]">5</span>
        </button>
        <button class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl transition flex items-center gap-1.5">
            <span>Dikirim</span>
            <span class="bg-sky-100 text-sky-700 px-1.5 py-0.5 rounded-md text-[10px]">7</span>
        </button>
        <button class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl transition flex items-center gap-1.5">
            <span>Selesai</span>
            <span class="bg-emerald-100 text-emerald-700 px-1.5 py-0.5 rounded-md text-[10px]">6</span>
        </button>
        <button class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-xl transition">Dibatalkan (0)</button>
    </div>

    {{-- List Pesanan Cards --}}
    <div class="space-y-4">
        @php
            $sampleOrders = [
                [
                    'id' => '#ORD-8921', 'kode' => 'NK', 'tgl' => '28 Sep 2026, 13:20', 'pembeli' => 'Budi Santoso', 'hp' => '0812-3456-7890',
                    'produk' => 'Nike Air Max 270 Black Red', 'varian' => 'Size 42', 'qty' => 1, 'total' => 1650000,
                    'kurir' => 'JNE Reguler', 'status' => 'Perlu Diproses', 'badge' => 'bg-amber-100 text-amber-800'
                ],
                [
                    'id' => '#ORD-8920', 'kode' => 'AD', 'tgl' => '28 Sep 2026, 11:05', 'pembeli' => 'Siti Rahmawati', 'hp' => '0857-1122-3344',
                    'produk' => 'Adidas Ultraboost 5.0 Triple White', 'varian' => 'Size 39', 'qty' => 1, 'total' => 1950000,
                    'kurir' => 'J&T Express', 'status' => 'Perlu Diproses', 'badge' => 'bg-amber-100 text-amber-800'
                ],
                [
                    'id' => '#ORD-8918', 'kode' => 'PM', 'tgl' => '27 Sep 2026, 19:40', 'pembeli' => 'Ahmad Fauzi', 'hp' => '0821-9988-7766',
                    'produk' => 'Puma RS-X Reinvent Grey', 'varian' => 'Size 43', 'qty' => 1, 'total' => 1250000,
                    'kurir' => 'SiCepat REG (Resi: JNE00192831)', 'status' => 'Dikirim', 'badge' => 'bg-sky-100 text-sky-800'
                ],
            ];
        @endphp

        @foreach($sampleOrders as $o)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-slate-100 text-xs">
                    <div class="flex items-center gap-3">
                        <span class="font-extrabold text-slate-800 text-sm">{{ $o['id'] }}</span>
                        <span class="text-slate-400">• {{ $o['tgl'] }}</span>
                        <span class="font-semibold text-slate-600">Kurir: {{ $o['kurir'] }}</span>
                    </div>
                    <span class="{{ $o['badge'] }} text-[11px] font-bold px-3 py-1 rounded-full">
                        {{ $o['status'] }}
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-700 font-black text-sm flex items-center justify-center shadow-inner flex-shrink-0">
                            {{ $o['kode'] }}
                        </div>
                        <div>
                            <h4 class="font-extrabold text-sm text-slate-800">{{ $o['produk'] }}</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Varian: <strong class="text-slate-700">{{ $o['varian'] }}</strong> ({{ $o['qty'] }} pasang)</p>
                            <p class="text-xs text-slate-400 mt-0.5">Pembeli: <strong>{{ $o['pembeli'] }}</strong> ({{ $o['hp'] }})</p>
                        </div>
                    </div>

                    <div class="text-right self-end sm:self-center">
                        <span class="text-xs text-slate-400 block">Total Pesanan</span>
                        <span class="text-base font-extrabold text-brand-600">Rp {{ number_format($o['total'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                    <span class="text-xs text-slate-400">Alamat: Jl. Merdeka No. 45, Jakarta Selatan</span>
                    <div class="flex items-center gap-2">
                        <button class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                            Cetak Label
                        </button>
                        @if($o['status'] === 'Perlu Diproses')
                            <button class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs rounded-xl shadow-sm transition">
                                Input Resi & Kirim
                            </button>
                        @else
                            <button class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white font-bold text-xs rounded-xl shadow-sm transition">
                                Detail Resi
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection