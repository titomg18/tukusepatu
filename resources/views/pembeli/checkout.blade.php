@extends('layouts.pembeli')

@section('title', 'Checkout Pesanan - TukuSepatu')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Checkout Pesanan</h1>
            <p class="text-xs text-slate-400 mt-0.5">Lengkapi alamat pengiriman untuk menyelesaikan pesanan kamu</p>
        </div>
        <a href="{{ route('pembeli.keranjang') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
            Kembali ke Keranjang
        </a>
    </div>

    <form action="{{ route('pembeli.checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf

        {{-- Form Alamat Pengiriman (2 Columns) --}}
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-6">
            <div>
                <h2 class="font-extrabold text-base text-slate-800 pb-3 border-b border-slate-100">
                    Informasi & Alamat Pengiriman Baru
                </h2>
                <p class="text-xs text-slate-400 mt-1">
                    Masukkan alamat tempat pengiriman paket sepatu pesananmu secara lengkap.
                </p>
            </div>

            {{-- Nama Penerima --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Nama Penerima
                </label>
                <input type="text" value="{{ Auth::user()->nama_user }}" readonly disabled
                       class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Email Pembeli
                </label>
                <input type="email" value="{{ Auth::user()->email }}" readonly disabled
                       class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-xs font-bold text-slate-700">
            </div>

            {{-- Input Alamat Lengkap --}}
            <div>
                <label for="alamat_pengiriman" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Alamat Lengkap Pengiriman Baru <span class="text-rose-500">*</span>
                </label>
                <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="4" required
                          placeholder="Masukkan nama jalan, No. rumah, RT/RW, Kecamatan, Kota/Kabupaten, Provinsi, Kode Pos..."
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">{{ old('alamat_pengiriman') }}</textarea>
                @error('alamat_pengiriman')
                    <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Ringkasan Pesanan (1 Column) --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 flex flex-col justify-between space-y-6 h-fit">
            <div>
                <h3 class="font-extrabold text-base text-slate-800 pb-3 border-b border-slate-100">
                    Ringkasan Produk
                </h3>

                <div class="divide-y divide-slate-100 my-3">
                    @foreach($cart as $item)
                        <div class="py-2 flex items-center justify-between text-xs">
                            <div>
                                <p class="font-bold text-slate-800 line-clamp-1">{{ $item['nama_product'] }}</p>
                                <p class="text-[10px] text-slate-400">{{ $item['jumlah'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                            </div>
                            <span class="font-extrabold text-slate-900">
                                Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-2 pt-3 border-t border-slate-100 text-xs">
                    <div class="flex justify-between text-slate-600">
                        <span>Metode Pembayaran</span>
                        <span class="font-bold text-slate-800">Transfer Bank / QRIS</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-extrabold text-slate-900 pt-2 border-t border-slate-100">
                        <span>Total Bayar</span>
                        <span class="text-base text-brand-600">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <button type="submit" 
                    class="w-full py-3 bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-brand-500/20 text-center transition">
                Buat Pesanan Sekarang
            </button>
        </div>

    </form>
</div>
@endsection
