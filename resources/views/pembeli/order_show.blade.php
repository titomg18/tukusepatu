@extends('layouts.pembeli')

@section('title', 'Detail Pesanan #' . $order->id_order . ' - TukuSepatu')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-2xl font-extrabold text-slate-800">Detail Pesanan #ORD-{{ $order->id_order }}</h1>
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
                <span class="text-xs font-bold px-3 py-1 rounded-full border {{ $statusBadges[$order->status_order] ?? 'bg-slate-100 text-slate-700' }}">
                    {{ strtoupper(str_replace('_', ' ', $order->status_order)) }}
                </span>
            </div>
            <p class="text-xs text-slate-400 mt-0.5">Dibuat pada: {{ $order->tgl_order->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
        </div>
        <a href="{{ route('pembeli.order.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
            Lihat Semua Pesanan Saya
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Column Left: Details & Items (2 Columns) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Rekening Pembayaran --}}
            @if($order->status_order === 'menunggu_bayar')
                <div class="bg-gradient-to-r from-slate-900 to-brand-950 rounded-3xl p-6 text-white shadow-lg space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-700/80 pb-3">
                        <h3 class="font-extrabold text-sm text-amber-400 uppercase tracking-wider">Instruksi Pembayaran Transfer Bank</h3>
                        <span class="text-[11px] font-bold bg-amber-400/20 text-amber-300 px-2.5 py-0.5 rounded-full">Batas 24 Jam</span>
                    </div>

                    <p class="text-xs text-slate-300">
                        Silakan lakukan transfer sebesar <strong class="text-amber-300 text-sm">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</strong> ke salah satu rekening resmi TukuSepatu berikut:
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div class="p-3 bg-slate-800/80 rounded-2xl border border-slate-700/80">
                            <span class="text-slate-400 font-medium block">Bank BCA</span>
                            <span class="text-sm font-extrabold text-white block mt-0.5">123-456-7890</span>
                            <span class="text-[10px] text-slate-400">a/n TukuSepatu Indonesia</span>
                        </div>

                        <div class="p-3 bg-slate-800/80 rounded-2xl border border-slate-700/80">
                            <span class="text-slate-400 font-medium block">Bank Mandiri</span>
                            <span class="text-sm font-extrabold text-white block mt-0.5">987-654-3210</span>
                            <span class="text-[10px] text-slate-400">a/n TukuSepatu Indonesia</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form / Status Upload Bukti Pembayaran --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 space-y-4">
                <h3 class="font-extrabold text-base text-slate-800 pb-3 border-b border-slate-100">
                    Bukti Pembayaran
                </h3>

                @if($order->bukti_bayar)
                    <div class="space-y-2">
                        <p class="text-xs text-slate-500 font-medium">Bukti pembayaran yang pernah diunggah:</p>
                        <div class="w-48 h-48 rounded-2xl border border-slate-200 overflow-hidden bg-slate-50 p-2">
                            <img src="{{ asset('storage/' . $order->bukti_bayar) }}" alt="Bukti Transfer" class="w-full h-full object-cover rounded-xl">
                        </div>
                        <p class="text-[11px] text-emerald-600 font-bold">Bukti transfer sudah terkirim ke sistem.</p>
                    </div>
                @else
                    <form action="{{ route('pembeli.order.upload_bukti', $order->id_order) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="bukti_bayar" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Unggah Foto Bukti Transfer <span class="text-rose-500">*</span>
                            </label>
                            <input type="file" name="bukti_bayar" id="bukti_bayar" accept="image/*" required
                                   class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-600 focus:outline-none transition">
                            <p class="text-[11px] text-slate-400 mt-1">Upload foto struk transfer / screenshot m-banking (Format JPG, PNG, WEBP max 2MB)</p>
                            @error('bukti_bayar')
                                <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                @endif
            </div>

            {{-- Item Pesanan --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 space-y-4">
                <h3 class="font-extrabold text-base text-slate-800 pb-3 border-b border-slate-100">
                    Produk Sepatu Yang Dibeli
                </h3>

                <div class="divide-y divide-slate-100 space-y-3">
                    @foreach($order->details as $detail)
                        <div class="pt-3 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center font-bold text-xs text-slate-600 flex-shrink-0">
                                    {{ strtoupper(substr($detail->produk->nama_product ?? 'SP', 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-slate-800">{{ $detail->produk->nama_product ?? 'Produk Sepatu' }}</h4>
                                    <p class="text-[11px] text-slate-400">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="font-extrabold text-slate-900">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- Column Right: Info Alamat & Total (1 Column) --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 space-y-6 h-fit">
            <div>
                <h3 class="font-extrabold text-base text-slate-800 pb-3 border-b border-slate-100">
                    Alamat Tujuan Pengiriman
                </h3>
                <p class="text-xs text-slate-700 font-medium leading-relaxed mt-3">
                    {{ $order->alamat_pengiriman }}
                </p>
            </div>

            <div class="pt-4 border-t border-slate-100 space-y-2 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Total Pembayaran</span>
                    <span class="font-extrabold text-base text-brand-600">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
