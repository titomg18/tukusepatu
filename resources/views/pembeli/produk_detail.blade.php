@extends('layouts.pembeli')

@section('title', $produk->nama_product . ' - TukuSepatu')

@section('content')
<div class="max-w-5xl space-y-6">

    {{-- Breadcrumb & Back button --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('pembeli.dashboard') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
            &larr; Kembali ke Katalog
        </a>
        <span class="text-xs text-slate-400 font-medium">Kategori: {{ $produk->kategori ?? 'Umum' }}</span>
    </div>

    {{-- Product Detail Card --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
        
        {{-- Product Image (Left Column) --}}
        <div class="space-y-3">
            <div class="w-full h-80 sm:h-96 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center p-4 relative">
                @if($produk->gambar_product)
                    <img src="{{ asset('storage/' . $produk->gambar_product) }}" alt="{{ $produk->nama_product }}" class="w-full h-full object-cover rounded-xl">
                @else
                    <span class="text-6xl font-black text-slate-300">
                        {{ strtoupper(substr($produk->nama_product, 0, 2)) }}
                    </span>
                @endif

                <span class="absolute top-4 left-4 text-xs font-bold {{ $produk->status_product === 'habis' || $produk->stok < 1 ? 'bg-rose-100 text-rose-700 border-rose-200' : 'bg-emerald-100 text-emerald-700 border-emerald-200' }} border px-3 py-1 rounded-full shadow-sm">
                    {{ $produk->status_product === 'habis' || $produk->stok < 1 ? 'Stok Habis' : 'Tersedia' }}
                </span>
            </div>
        </div>

        {{-- Product Metadata & Purchase Actions (Right Column) --}}
        <div class="space-y-6">
            <div class="space-y-2 border-b border-slate-100 pb-4">
                <span class="text-xs font-bold bg-brand-50 text-brand-600 px-3 py-1 rounded-full border border-brand-100">
                    {{ $produk->kategori ?? 'Sepatu' }}
                </span>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-2">
                    {{ $produk->nama_product }}
                </h1>

                <p class="text-xs text-slate-500 font-medium">
                    Penjual / Toko: <strong class="text-slate-800">{{ $produk->penjual->nama_user ?? 'Penjual Official' }}</strong>
                </p>
            </div>

            {{-- Price & Stock --}}
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-1">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Harga Produk</span>
                <div class="flex items-baseline justify-between">
                    <span class="text-3xl font-black text-brand-600">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </span>
                    <span class="text-xs font-bold text-slate-600">
                        Sisa Stok: <strong class="{{ $produk->stok <= 2 ? 'text-rose-600' : 'text-slate-800' }}">{{ $produk->stok }} pasang</strong>
                    </span>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="space-y-2">
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi Sepatu:</h3>
                <p class="text-xs text-slate-600 leading-relaxed bg-slate-50/50 p-4 rounded-2xl border border-slate-100 whitespace-pre-line">
                    {{ $produk->deskripsi ?? 'Sepatu berkualitas tinggi dengan desain modern dan kenyamanan ekstra untuk pemakaian sehari-hari.' }}
                </p>
            </div>

            {{-- Purchase Form --}}
            @if($produk->status_product !== 'habis' && $produk->stok > 0)
                <form action="{{ route('pembeli.keranjang.add') }}" method="POST" class="space-y-4 pt-2">
                    @csrf
                    <input type="hidden" name="id_product" value="{{ $produk->id_product }}">

                    <div>
                        <label for="jumlah" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Jumlah Pembelian
                        </label>
                        <div class="flex items-center gap-3">
                            <input type="number" name="jumlah" id="jumlah" value="1" min="1" max="{{ $produk->stok }}"
                                   class="w-24 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-center focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                            <span class="text-xs text-slate-400">Pasang</span>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full py-3.5 bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-brand-500/20 transition active:scale-[0.98] flex items-center justify-center gap-2">
                        <span>+ Tambahkan ke Keranjang Belanja</span>
                    </button>
                </form>
            @else
                <button disabled class="w-full py-3.5 bg-slate-100 text-slate-400 font-bold text-xs rounded-xl cursor-not-allowed text-center">
                    Stok Produk Habis
                </button>
            @endif
        </div>

    </div>

</div>
@endsection
