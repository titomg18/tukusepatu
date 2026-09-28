<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Katalog Produk Penjual - TukuSepatu')</title>

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
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                            dark: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

    <div class="flex min-h-screen">
        {{-- ================= SIDEBAR PENJUAL ================= --}}
        <aside id="sidebar" class="w-64 bg-slate-900 text-slate-300 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl">
            
            {{-- Brand Logo Header --}}
            <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800/80">
                <a href="{{ route('penjual.produk') }}" class="group">
                    <div>
                        <span class="font-extrabold text-lg text-white tracking-wide block leading-tight">TukuSepatu</span>
                        <span class="text-[11px] font-semibold tracking-wider uppercase text-brand-400">Seller Hub</span>
                    </div>
                </a>
                <button id="closeSidebar" class="lg:hidden text-slate-400 hover:text-white text-xs font-bold px-2 py-1 bg-slate-800 rounded">
                    Tutup
                </button>
            </div>


            {{-- Sidebar Navigation Links (Tanpa Dashboard) --}}
            <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500 px-3 pt-2 pb-1">Menu Utama</div>
                
                <a href="{{ route('penjual.produk') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('penjual.produk') ? 'bg-brand-500 text-white shadow-lg shadow-brand-500/25 font-semibold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                    <span>Katalog Produk</span>
                    @if(request()->routeIs('penjual.produk'))
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                    @endif
                </a>

                <a href="{{ route('penjual.pesanan') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('penjual.pesanan') ? 'bg-brand-500 text-white shadow-lg shadow-brand-500/25 font-semibold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                    <span>Pesanan Masuk</span>
                    @if(request()->routeIs('penjual.pesanan'))
                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                    @endif
                </a>

                <a href="{{ route('penjual.toko') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 {{ request()->routeIs('penjual.toko') ? 'bg-brand-500 text-white shadow-lg shadow-brand-500/25 font-semibold' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                    <span>Profil Toko</span>
                </a>

            </nav>

            {{-- Sidebar Footer Card --}}
            <div class="p-4 border-t border-slate-800">
                <div class="bg-gradient-to-r from-slate-800 to-slate-800/80 rounded-xl p-3.5 border border-slate-700/60 flex items-center justify-between">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-500 to-amber-500 flex items-center justify-center text-white font-bold text-sm shadow-md flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->nama_user ?? 'P', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->nama_user ?? 'Penjual' }}</p>
                            <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email ?? 'seller@tukusepatu.id' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Mobile Overlay --}}
        <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity"></div>

        {{-- ================= MAIN CONTENT AREA ================= --}}
        <div class="flex-1 flex flex-col lg:pl-64 min-w-0">
            
            {{-- Top Navbar --}}
            <header class="h-20 bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 px-4 sm:px-8 flex items-center justify-between gap-4 shadow-sm">
                
                {{-- Left: Mobile Hamburger & Search --}}
                <div class="flex items-center gap-4 flex-1">
                    <button id="openSidebar" class="lg:hidden text-xs font-bold text-slate-700 px-3 py-2 rounded-xl bg-slate-100 border border-slate-200">
                        Menu
                    </button>

                    <div class="relative w-full max-w-md hidden md:block">
                        <input type="text" placeholder="Cari nama sepatu, pesanan, atau pembeli..." 
                               class="w-full px-4 py-2 bg-slate-100/80 border border-slate-200 rounded-xl text-xs font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition">
                    </div>
                </div>

                {{-- Right: Actions & User Dropdown --}}
                <div class="flex items-center gap-3 sm:gap-4">

                    {{-- Quick Action Button --}}
                    <a href="{{ route('penjual.produk') }}" class="hidden sm:inline-flex items-center gap-2 bg-gradient-to-r from-brand-600 to-amber-500 hover:from-brand-700 hover:to-amber-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md shadow-brand-500/20 hover:shadow-lg transition-all duration-200">
                        <span>Tambah Produk</span>
                    </a>


                    {{-- Divider --}}
                    <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                    {{-- User Profile Dropdown --}}
                    <div class="relative group">
                        <button class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-slate-100 transition focus:outline-none">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-500 to-orange-500 flex items-center justify-center text-white font-extrabold text-sm shadow-sm ring-2 ring-brand-500/20">
                                {{ strtoupper(substr(Auth::user()->nama_user ?? 'P', 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <span class="block text-xs font-bold text-slate-800 leading-none">{{ Auth::user()->nama_user ?? 'Seller' }}</span>
                                <span class="text-[10px] text-slate-400 font-semibold mt-0.5 block">Penjual Verified</span>
                            </div>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="text-xs font-bold text-slate-800">{{ Auth::user()->nama_user ?? 'User' }}</p>
                                <p class="text-[11px] text-slate-400">{{ Auth::user()->email ?? 'user@tukusepatu.id' }}</p>
                            </div>

                            <a href="{{ route('penjual.produk') }}" class="block px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition">
                                Katalog Produk
                            </a>
                            <a href="{{ route('penjual.pesanan') }}" class="block px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition">
                                Pesanan Masuk
                            </a>
                            <a href="{{ route('penjual.toko') }}" class="block px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition">
                                Pengaturan Toko
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
                </div>
            </header>

            {{-- Main Page Content --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="bg-white border-t border-slate-200/80 py-4 px-8 text-center sm:flex sm:items-center sm:justify-between text-xs text-slate-500">
                <p>© {{ date('Y') }} <span class="font-semibold text-slate-700">TukuSepatu</span> — Dashboard Mitra Penjual Indonesia.</p>
                <div class="flex items-center justify-center gap-4 mt-2 sm:mt-0">
                    <a href="#" class="hover:text-brand-600 transition">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-brand-600 transition">Panduan Penjual</a>
                    <a href="#" class="hover:text-brand-600 transition">Bantuan</a>
                </div>
            </footer>
        </div>
    </div>

    <!-- Mobile Drawer Toggle Script -->
    <script>
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }

        if(openSidebar) openSidebar.addEventListener('click', toggleSidebar);
        if(closeSidebar) closeSidebar.addEventListener('click', toggleSidebar);
        if(sidebarOverlay) sidebarOverlay.addEventListener('click', toggleSidebar);
    </script>
    @stack('scripts')
</body>
</html>
