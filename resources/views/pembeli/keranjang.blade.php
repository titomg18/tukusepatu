@extends('layouts.pembeli')

@section('title', 'Keranjang Belanja - TukuSepatu')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Keranjang Belanja</h1>
            <p class="text-xs text-slate-400 mt-0.5">Periksa kembali sepatu pilihanmu sebelum melakukan checkout</p>
        </div>
        <a href="{{ route('pembeli.dashboard') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
            Lanjut Belanja
        </a>
    </div>

    @if(!empty($cart) && count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Daftar Produk Cart (2 Columns) --}}
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 space-y-4">
                <h2 class="font-extrabold text-base text-slate-800 pb-3 border-b border-slate-100">
                    Daftar Produk ({{ count($cart) }} Item)
                </h2>

                <div class="divide-y divide-slate-100 space-y-4">
                    @foreach($cart as $item)
                        <div class="pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center font-black text-sm text-slate-600 flex-shrink-0 overflow-hidden">
                                    @if(!empty($item['gambar_product']))
                                        <img src="{{ asset('storage/' . $item['gambar_product']) }}" alt="{{ $item['nama_product'] }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($item['nama_product'], 0, 2)) }}
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-800">{{ $item['nama_product'] }}</h4>
                                    <p class="text-xs text-slate-400 mt-0.5">Kategori: {{ $item['kategori'] ?? 'Sepatu' }}</p>
                                    <p class="text-xs font-bold text-brand-600 mt-1">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-4">
                                {{-- Form Update Qty --}}
                                <form action="{{ route('pembeli.keranjang.update') }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="id_product" value="{{ $item['id_product'] }}">
                                    <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1" 
                                           class="w-16 px-2 py-1 bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold text-center focus:outline-none">
                                    <button type="submit" class="px-2.5 py-1 bg-slate-800 hover:bg-slate-900 text-white font-bold text-[11px] rounded-lg transition">
                                        Update
                                    </button>
                                </form>

                                {{-- Subtotal --}}
                                <div class="text-right">
                                    <span class="text-[10px] text-slate-400 block">Subtotal</span>
                                    <span class="text-xs font-extrabold text-slate-900">
                                        Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Form Remove --}}
                                <form action="{{ route('pembeli.keranjang.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_product" value="{{ $item['id_product'] }}">
                                    <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 font-bold text-xs rounded-lg transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Ringkasan Pembayaran (1 Column) --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 flex flex-col justify-between h-fit space-y-6">
                <div>
                    <h3 class="font-extrabold text-base text-slate-800 pb-3 border-b border-slate-100">
                        Ringkasan Pesanan
                    </h3>

                    <div class="space-y-3 my-4 text-xs font-medium text-slate-600">
                        <div class="flex justify-between">
                            <span>Total Harga Produk</span>
                            <span class="font-bold text-slate-800">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya Pengiriman</span>
                            <span class="font-bold text-emerald-600">GRATIS ONGKIR</span>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex justify-between items-center text-sm font-extrabold text-slate-900">
                            <span>Total Pembayaran</span>
                            <span class="text-base text-brand-600">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('pembeli.checkout') }}" 
                   class="w-full py-3 bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-brand-500/20 text-center block transition">
                    Lanjut ke Checkout &rarr;
                </a>
            </div>

        </div>
    @else
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-sm space-y-4 max-w-lg mx-auto">
            <div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-600 font-black text-2xl flex items-center justify-center mx-auto shadow-inner">
                TS
            </div>
            <div>
                <h3 class="font-extrabold text-slate-800 text-base">Keranjang Belanja Masih Kosong</h3>
                <p class="text-xs text-slate-400 mt-1">Kamu belum menambahkan produk sepatu apapun ke keranjang belanja.</p>
            </div>
            <a href="{{ route('pembeli.dashboard') }}" class="inline-block px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                Mulai Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection
