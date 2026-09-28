@extends('layouts.penjual')

@section('title', 'Profil Toko - TukuSepatu Seller Hub')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800">Profil & Pengaturan Toko</h1>
        <p class="text-xs text-slate-400 mt-0.5">Kelola informasi publik toko, alamat pengiriman, dan identitas penjual</p>
    </div>

    {{-- Store Banner Card --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 space-y-6">
        <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-slate-100">
            <div class="w-24 h-24 rounded-3xl bg-gradient-to-tr from-brand-500 via-orange-500 to-amber-400 flex items-center justify-center text-white text-4xl font-black shadow-lg shadow-brand-500/25 ring-4 ring-orange-100 flex-shrink-0">
                {{ strtoupper(substr(Auth::user()->nama_user ?? 'T', 0, 1)) }}
            </div>
            <div class="text-center sm:text-left space-y-1">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                    <h2 class="text-xl font-extrabold text-slate-800">{{ Auth::user()->nama_user }}</h2>
                    <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-emerald-200">
                        Penjual Terverifikasi
                    </span>
                </div>
                <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                <p class="text-xs text-slate-500 font-medium pt-1">
                    Mitra Penjual Resmi TukuSepatu Indonesia
                </p>
            </div>
        </div>

        {{-- Details Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                <span class="text-slate-400 font-medium">Tanggal Bergabung</span>
                <p class="font-extrabold text-slate-800 text-sm">
                    {{ \Carbon\Carbon::parse(Auth::user()->tgl_daftar ?? now())->isoFormat('D MMMM Y') }}
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                <span class="text-slate-400 font-medium">Status Akun Penjual</span>
                <p class="font-extrabold text-emerald-600 text-sm capitalize flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    {{ Auth::user()->status_user ?? 'Aktif' }}
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                <span class="text-slate-400 font-medium">Role Pengguna</span>
                <p class="font-extrabold text-slate-800 text-sm capitalize">
                    {{ Auth::user()->role ?? 'Penjual' }}
                </p>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                <span class="text-slate-400 font-medium">Performa Respon Chat</span>
                <p class="font-extrabold text-brand-600 text-sm">
                    99.0% (Sangat Cepat)
                </p>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button class="bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-sm transition">
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>
@endsection