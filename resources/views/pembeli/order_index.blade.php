@extends('layouts.pembeli')

@section('title', 'Daftar Pesanan Saya - TukuSepatu')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Daftar Pesanan Saya</h1>
            <p class="text-xs text-slate-400 mt-0.5">Lacak status transaksi dan riwayat belanja sepatu kamu</p>
        </div>
        <a href="{{ route('pembeli.dashboard') }}" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl transition">
            Belanja Lagi
        </a>
    </div>

    {{-- Filter Tabs Status --}}
    <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-200/80 flex flex-wrap gap-1 text-xs font-bold">
        <a href="{{ route('pembeli.order.index', ['status' => 'semua']) }}" 
           class="px-4 py-2 rounded-xl transition {{ request('status', 'semua') == 'semua' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Semua
        </a>
        <a href="{{ route('pembeli.order.index', ['status' => 'menunggu_bayar']) }}" 
           class="px-4 py-2 rounded-xl transition {{ request('status') == 'menunggu_bayar' ? 'bg-amber-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Menunggu Bayar
        </a>
        <a href="{{ route('pembeli.order.index', ['status' => 'menunggu_konfirmasi']) }}" 
           class="px-4 py-2 rounded-xl transition {{ request('status') == 'menunggu_konfirmasi' ? 'bg-sky-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Menunggu Konfirmasi
        </a>
        <a href="{{ route('pembeli.order.index', ['status' => 'diproses']) }}" 
           class="px-4 py-2 rounded-xl transition {{ request('status') == 'diproses' ? 'bg-indigo-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Diproses
        </a>
        <a href="{{ route('pembeli.order.index', ['status' => 'dikirim']) }}" 
           class="px-4 py-2 rounded-xl transition {{ request('status') == 'dikirim' ? 'bg-blue-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Dikirim
        </a>
        <a href="{{ route('pembeli.order.index', ['status' => 'selesai']) }}" 
           class="px-4 py-2 rounded-xl transition {{ request('status') == 'selesai' ? 'bg-emerald-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            Selesai
        </a>
    </div>

    {{-- Order List --}}
    @if(isset($orders) && count($orders) > 0)
        <div class="space-y-4">
            @foreach($orders as $o)
                @php
                    $statusBadges = [
                        'menunggu_bayar' => 'bg-amber-100 text-amber-800 border-amber-200',
                        'menunggu_konfirmasi' => 'bg-sky-100 text-sky-800 border-sky-200',
                        'diproses' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                        'dikirim' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                        'dibatalkan' => 'bg-rose-100 text-rose-800 border-rose-200',
                    ];
                @endphp
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-slate-100 text-xs">
                        <div class="flex items-center gap-3">
                            <span class="font-extrabold text-slate-900 text-sm">#ORD-{{ $o->id_order }}</span>
                            <span class="text-slate-400">• {{ $o->tgl_order->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
                        </div>
                        <span class="text-[11px] font-bold px-3 py-1 rounded-full border {{ $statusBadges[$o->status_order] ?? 'bg-slate-100 text-slate-700' }}">
                            {{ strtoupper(str_replace('_', ' ', $o->status_order)) }}
                        </span>
                    </div>

                    {{-- Products summary in order --}}
                    <div class="space-y-2">
                        @foreach($o->details as $d)
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-slate-800">
                                    {{ $d->produk->nama_product ?? 'Produk Sepatu' }} <span class="text-slate-400 font-normal">({{ $d->jumlah }} pasang)</span>
                                </span>
                                <span class="font-semibold text-slate-600">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                        <div>
                            <span class="text-slate-400 block">Total Tagihan</span>
                            <span class="text-sm font-extrabold text-brand-600">Rp {{ number_format($o->total_harga, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            @if($o->status_order === 'menunggu_bayar')
                                <a href="{{ route('pembeli.order.show', $o->id_order) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition">
                                    Upload Bukti Bayar
                                </a>
                            @else
                                <a href="{{ route('pembeli.order.show', $o->id_order) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition">
                                    Lihat Detail & Status
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-sm space-y-4 max-w-lg mx-auto">
            <div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-600 font-black text-2xl flex items-center justify-center mx-auto shadow-inner">
                TS
            </div>
            <div>
                <h3 class="font-extrabold text-slate-800 text-base">Belum Ada Pesanan</h3>
                <p class="text-xs text-slate-400 mt-1">Kamu belum pernah membuat pesanan sepatu di TukuSepatu.</p>
            </div>
            <a href="{{ route('pembeli.dashboard') }}" class="inline-block px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                Belanja Sepatu Sekarang
            </a>
        </div>
    @endif
</div>
@endsection
