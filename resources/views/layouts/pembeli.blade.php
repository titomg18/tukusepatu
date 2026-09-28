<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TukuSepatu - Toko Sepatu Online Indonesia')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    {{-- ================= TOP NAVBAR ================= --}}
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                {{-- Brand Logo & Links --}}
                <div class="flex items-center gap-8">
                    <a href="{{ route('pembeli.dashboard') }}" class="group">
                        <div>
                            <span class="font-extrabold text-lg text-slate-900 tracking-wide block leading-tight">TukuSepatu</span>
                            <span class="text-[11px] font-semibold tracking-wider text-brand-600 block">Belanja Sepatu Impian</span>
                        </div>
                    </a>

                    {{-- Navigation Tabs --}}
                    <nav class="hidden md:flex items-center gap-1.5 bg-slate-100 p-1.5 rounded-2xl text-xs font-bold">
                        <a href="{{ route('pembeli.dashboard') }}" 
                           class="px-4 py-2 rounded-xl transition-all {{ request()->routeIs('pembeli.dashboard') || request()->is('/') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                            Beranda
                        </a>
                        @auth
                            <a href="{{ route('pembeli.order.index') }}" 
                               class="px-4 py-2 rounded-xl transition-all {{ request()->routeIs('pembeli.order.*') ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                                Pesanan Saya
                            </a>
                        @endauth
                    </nav>
                </div>

                {{-- Right Actions: Keranjang & Auth --}}
                <div class="flex items-center gap-3 sm:gap-4">
                    
                    {{-- Keranjang Belanja Button --}}
                    @php
                        $cartItems = session('cart', []);
                        $cartTotalCount = array_sum(array_column($cartItems, 'jumlah'));
                    @endphp
                    <a href="{{ route('pembeli.keranjang') }}" 
                       class="flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200/80 text-slate-800 text-xs font-bold rounded-xl transition">
                        <span>Keranjang</span>
                        <span class="bg-brand-600 text-white font-black px-2 py-0.5 rounded-md text-[10px]">
                            {{ $cartTotalCount }}
                        </span>
                    </a>

                    @auth
                        {{-- User Profile Dropdown --}}
                        <div class="relative group">
                            <button class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-slate-100 transition focus:outline-none">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-600 flex items-center justify-center text-white font-extrabold text-sm shadow-sm">
                                    {{ strtoupper(substr(Auth::user()->nama_user ?? 'U', 0, 1)) }}
                                </div>
                                <div class="hidden sm:block text-left">
                                    <span class="block text-xs font-bold text-slate-800 leading-none">{{ Auth::user()->nama_user }}</span>
                                    <span class="text-[10px] text-slate-400 font-semibold mt-0.5 block capitalize">{{ Auth::user()->role }}</span>
                                </div>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div class="absolute right-0 mt-2 w-56 bg-white text-slate-800 rounded-2xl shadow-xl border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="px-4 py-2.5 border-b border-slate-100">
                                    <p class="text-xs font-bold text-slate-800">{{ Auth::user()->nama_user }}</p>
                                    <p class="text-[11px] text-slate-400">{{ Auth::user()->email }}</p>
                                </div>

                                @if(Auth::user()->role === 'penjual')
                                    <a href="{{ route('penjual.produk') }}" class="block px-4 py-2.5 text-xs font-bold text-brand-600 hover:bg-brand-50 transition">
                                        Panel Penjual
                                    </a>
                                    <hr class="my-1 border-slate-100">
                                @endif

                                <a href="{{ route('pembeli.dashboard') }}" class="block px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition">
                                    Katalog Sepatu
                                </a>
                                <a href="{{ route('pembeli.keranjang') }}" class="block px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition">
                                    Keranjang Belanja
                                </a>
                                <a href="{{ route('pembeli.order.index') }}" class="block px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition">
                                    Pesanan Saya
                                </a>
                                
                                <hr class="my-1 border-slate-100">

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Guest Actions: Login / Register --}}
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-xl shadow-md transition">
                                Daftar
                            </a>
                        </div>
                    @endauth

                </div>
            </div>

            {{-- Mobile Navbar Links --}}
            <div class="flex md:hidden items-center justify-between border-t border-slate-100 py-2.5 text-xs font-semibold">
                <a href="{{ route('pembeli.dashboard') }}" class="{{ request()->routeIs('pembeli.dashboard') || request()->is('/') ? 'text-brand-600 font-bold' : 'text-slate-600' }}">Beranda</a>
                <a href="{{ route('pembeli.keranjang') }}" class="{{ request()->routeIs('pembeli.keranjang') ? 'text-brand-600 font-bold' : 'text-slate-600' }}">Keranjang ({{ $cartTotalCount }})</a>
                @auth
                    <a href="{{ route('pembeli.order.index') }}" class="{{ request()->routeIs('pembeli.order.*') ? 'text-brand-600 font-bold' : 'text-slate-600' }}">Pesanan Saya</a>
                @else
                    <a href="{{ route('login') }}" class="text-brand-600 font-bold">Masuk</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 sm:p-6 lg:p-8">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 px-5 py-4 rounded-2xl flex items-center justify-between shadow-sm text-xs">
                <div>
                    <h4 class="font-bold text-sm text-emerald-900">Berhasil!</h4>
                    <p class="mt-0.5">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="font-bold underline text-emerald-800">Tutup</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl flex items-center justify-between shadow-sm text-xs">
                <div>
                    <h4 class="font-bold text-sm text-rose-900">Perhatian!</h4>
                    <p class="mt-0.5">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="font-bold underline text-rose-800">Tutup</button>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-slate-200/80 py-6 px-4 sm:px-8 mt-auto">
        <div class="max-w-7xl mx-auto text-center sm:flex sm:items-center sm:justify-between text-xs text-slate-500">
            <p>© {{ date('Y') }} <span class="font-semibold text-slate-700">TukuSepatu</span> — Platform Jual Beli Sepatu Terpercaya.</p>
            <div class="flex items-center justify-center gap-4 mt-2 sm:mt-0">
                <a href="#" class="hover:text-brand-600 transition">Cara Belanja</a>
                <a href="#" class="hover:text-brand-600 transition">Ketentuan Pengembalian</a>
                <a href="#" class="hover:text-brand-600 transition">Bantuan</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
