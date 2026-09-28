@extends('layouts.penjual')

@section('title', 'Pesanan Masuk - TukuSepatu Seller Hub')

@section('content')
<div class="space-y-6">

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 px-5 py-4 rounded-2xl flex items-center justify-between shadow-sm text-xs">
            <div>
                <h4 class="font-bold text-sm text-emerald-900">Berhasil!</h4>
                <p class="mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="font-bold underline text-emerald-800">Tutup</button>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Kelola Pesanan Masuk</h1>
            <p class="text-xs text-slate-400 mt-0.5">Pantau transaksi pesanan pembeli, konfirmasi pembayaran, dan ubah status pengiriman</p>
        </div>
    </div>

    {{-- Tabs Status Filter --}}
    <div class="bg-white rounded-2xl p-2 shadow-sm border border-slate-200/80 flex flex-wrap gap-1 text-xs font-bold">
        <a href="{{ route('penjual.pesanan', ['status' => 'semua']) }}" 
           class="px-4 py-2 rounded-xl transition flex items-center gap-1.5 {{ request('status', 'semua') == 'semua' ? 'bg-brand-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            <span>Semua</span>
            <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ request('status', 'semua') == 'semua' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['semua'] ?? 0 }}</span>
        </a>

        <a href="{{ route('penjual.pesanan', ['status' => 'menunggu_konfirmasi']) }}" 
           class="px-4 py-2 rounded-xl transition flex items-center gap-1.5 {{ request('status') == 'menunggu_konfirmasi' ? 'bg-sky-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            <span>Menunggu Konfirmasi</span>
            <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ request('status') == 'menunggu_konfirmasi' ? 'bg-white/20 text-white' : 'bg-sky-100 text-sky-700' }}">{{ $counts['menunggu_konfirmasi'] ?? 0 }}</span>
        </a>

        <a href="{{ route('penjual.pesanan', ['status' => 'diproses']) }}" 
           class="px-4 py-2 rounded-xl transition flex items-center gap-1.5 {{ request('status') == 'diproses' ? 'bg-indigo-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            <span>Perlu Diproses</span>
            <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ request('status') == 'diproses' ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-700' }}">{{ $counts['diproses'] ?? 0 }}</span>
        </a>

        <a href="{{ route('penjual.pesanan', ['status' => 'dikirim']) }}" 
           class="px-4 py-2 rounded-xl transition flex items-center gap-1.5 {{ request('status') == 'dikirim' ? 'bg-blue-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            <span>Dikirim</span>
            <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ request('status') == 'dikirim' ? 'bg-white/20 text-white' : 'bg-blue-100 text-blue-700' }}">{{ $counts['dikirim'] ?? 0 }}</span>
        </a>

        <a href="{{ route('penjual.pesanan', ['status' => 'selesai']) }}" 
           class="px-4 py-2 rounded-xl transition flex items-center gap-1.5 {{ request('status') == 'selesai' ? 'bg-emerald-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            <span>Selesai</span>
            <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ request('status') == 'selesai' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-700' }}">{{ $counts['selesai'] ?? 0 }}</span>
        </a>

        <a href="{{ route('penjual.pesanan', ['status' => 'menunggu_bayar']) }}" 
           class="px-4 py-2 rounded-xl transition flex items-center gap-1.5 {{ request('status') == 'menunggu_bayar' ? 'bg-amber-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100' }}">
            <span>Menunggu Bayar</span>
            <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ request('status') == 'menunggu_bayar' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-700' }}">{{ $counts['menunggu_bayar'] ?? 0 }}</span>
        </a>
    </div>

    {{-- Orders List --}}
    @if(isset($orders) && count($orders) > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
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
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 space-y-5">
                    
                    {{-- Header Order Card --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-slate-100 text-xs">
                        <div class="space-y-0.5">
                            <div class="flex items-center gap-2">
                                <span class="font-black text-slate-900 text-sm">#ORD-{{ $order->id_order }}</span>
                                <span class="text-slate-400">• {{ $order->tgl_order->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
                            </div>
                            <p class="text-slate-500 text-xs">
                                Pembeli: <strong class="text-slate-800">{{ $order->pembeli->nama_user ?? 'Pembeli' }}</strong> ({{ $order->pembeli->email ?? '-' }})
                            </p>
                        </div>
                        <span class="text-[11px] font-bold px-3 py-1 rounded-full border {{ $statusBadges[$order->status_order] ?? 'bg-slate-100 text-slate-700' }}">
                            {{ strtoupper(str_replace('_', ' ', $order->status_order)) }}
                        </span>
                    </div>

                    {{-- Section 2: Items & Proof --}}
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        {{-- Products in this Order (2 Columns) --}}
                        <div class="lg:col-span-2 space-y-3">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Produk Sepatu Pesanan:</h4>
                            <div class="divide-y divide-slate-100">
                                @foreach($order->details as $detail)
                                    <div class="py-2.5 flex items-center justify-between text-xs">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs flex items-center justify-center flex-shrink-0 overflow-hidden">
                                                @if(!empty($detail->produk->gambar_product))
                                                    <img src="{{ asset('storage/' . $detail->produk->gambar_product) }}" alt="{{ $detail->produk->nama_product }}" class="w-full h-full object-cover">
                                                @else
                                                    {{ strtoupper(substr($detail->produk->nama_product ?? 'SP', 0, 2)) }}
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-extrabold text-slate-800">{{ $detail->produk->nama_product ?? 'Produk Sepatu' }}</p>
                                                <p class="text-[11px] text-slate-400">Jumlah: {{ $detail->jumlah }} pasang @ Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        <span class="font-extrabold text-slate-900">
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Alamat Pengiriman --}}
                            <div class="pt-3 border-t border-slate-100 text-xs">
                                <span class="font-bold text-slate-700 block mb-1">Alamat Pengiriman Tujuan:</span>
                                <p class="text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100 leading-relaxed">
                                    {{ $order->alamat_pengiriman }}
                                </p>
                            </div>
                        </div>

                        {{-- Payment Proof Box (1 Column) --}}
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/60 flex flex-col justify-between space-y-3">
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bukti Transfer Pembayaran:</h4>
                                @if($order->bukti_bayar)
                                    <div class="w-full h-40 rounded-xl overflow-hidden border border-slate-200 bg-white p-1">
                                        <a href="{{ asset('storage/' . $order->bukti_bayar) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $order->bukti_bayar) }}" alt="Bukti Transfer" class="w-full h-full object-cover rounded-lg hover:opacity-90 transition">
                                        </a>
                                    </div>
                                    <span class="text-[10px] text-emerald-600 font-bold block mt-1">Foto bukti transfer diunggah pembeli</span>
                                @else
                                    <div class="w-full h-40 rounded-xl border border-dashed border-slate-300 flex items-center justify-center text-center p-4 text-xs text-slate-400 bg-white">
                                        Pembeli belum mengunggah foto bukti pembayaran.
                                    </div>
                                @endif
                            </div>

                            <div class="pt-2 border-t border-slate-200 text-xs flex justify-between items-center">
                                <span class="text-slate-500 font-medium">Total Pesanan:</span>
                                <span class="font-extrabold text-sm text-brand-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>

                    </div>

                    {{-- Actions Footer --}}
                    <div class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                        <span class="text-slate-400">Pilih status pengemasan atau konfirmasi transaksi di samping:</span>

                        <div class="flex items-center gap-2">
                            @if($order->status_order === 'menunggu_konfirmasi')
                                <form action="{{ route('penjual.pesanan.update_status', $order->id_order) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_order" value="diproses">
                                    <button type="submit" class="px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white font-bold rounded-xl shadow-sm transition">
                                        Konfirmasi Bayar & Diproses
                                    </button>
                                </form>
                            @elseif($order->status_order === 'diproses')
                                <form action="{{ route('penjual.pesanan.update_status', $order->id_order) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_order" value="dikirim">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition">
                                        Kirim Pesanan Sekarang
                                    </button>
                                </form>
                            @elseif($order->status_order === 'dikirim')
                                <form action="{{ route('penjual.pesanan.update_status', $order->id_order) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_order" value="selesai">
                                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-sm transition">
                                        Tandai Pesanan Selesai
                                    </button>
                                </form>
                            @endif

                            @if($order->status_order !== 'selesai' && $order->status_order !== 'dibatalkan')
                                <form action="{{ route('penjual.pesanan.update_status', $order->id_order) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_order" value="dibatalkan">
                                    <button type="submit" class="px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold rounded-xl transition">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-sm space-y-3">
            <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-500 font-black text-xl flex items-center justify-center mx-auto">
                TS
            </div>
            <h3 class="font-extrabold text-slate-800 text-base">Belum Ada Pesanan Masuk</h3>
            <p class="text-xs text-slate-400 max-w-sm mx-auto">Pesanan sepatu dari pembeli akan otomatis muncul di halaman ini.</p>
        </div>
    @endif

</div>
@endsection