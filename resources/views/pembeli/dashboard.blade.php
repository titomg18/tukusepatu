<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembeli - Toko Sepatu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- ============ NAVBAR ============ --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                {{-- Logo --}}
                <a href="{{ route('pembeli.dashboard') }}" class="flex items-center gap-2">
                    <span class="text-2xl">👟</span>
                    <span class="font-bold text-xl text-gray-800">Toko Sepatu</span>
                </a>

                {{-- Search --}}
                <div class="hidden md:flex flex-1 max-w-md mx-8">
                    <div class="relative w-full">
                        <input type="text" placeholder="Cari sepatu favoritmu..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    </div>
                </div>

                {{-- Menu Kanan --}}
                <div class="flex items-center gap-4">
                    <a href="#" class="relative text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>

                    <a href="#" class="relative text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-bell text-xl"></i>
                    </a>

                    {{-- Profil Dropdown --}}
                    <div class="relative group">
                        <button class="flex items-center gap-2 focus:outline-none">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->nama_user, 0, 1)) }}
                            </div>
                            <span class="hidden md:block text-sm font-medium text-gray-700">{{ Auth::user()->nama_user }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>

                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user w-4"></i> Profil Saya
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-box w-4"></i> Pesanan Saya
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-heart w-4"></i> Wishlist
                            </a>
                            <hr class="my-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt w-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- ============ ALERT ============ --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- ============ CONTENT ============ --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Welcome Banner --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 text-white mb-8 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-blue-100 text-sm">Selamat datang kembali,</p>
                <h1 class="text-3xl font-bold mt-1">{{ Auth::user()->nama_user }} 👋</h1>
                <p class="text-blue-100 mt-2">Temukan sepatu impianmu hari ini!</p>
                <button class="mt-4 bg-white text-blue-600 font-semibold px-5 py-2 rounded-lg hover:bg-blue-50 transition">
                    <i class="fas fa-shopping-bag mr-2"></i>Mulai Belanja
                </button>
            </div>
            <div class="absolute right-0 top-0 h-full w-1/3 flex items-center justify-center opacity-10 text-9xl">
                👟
            </div>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs">Total Pesanan</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">0</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-blue-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs">Dikirim</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">0</p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-truck text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs">Selesai</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">0</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-xs">Wishlist</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">0</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heart text-red-500"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kategori --}}
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">Kategori Populer</h2>
                <a href="#" class="text-sm text-blue-600 hover:underline">Lihat semua</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $kategori = [
                        ['nama' => 'Sneakers', 'icon' => '👟', 'bg' => 'from-blue-400 to-blue-600'],
                        ['nama' => 'Running',  'icon' => '🏃', 'bg' => 'from-green-400 to-green-600'],
                        ['nama' => 'Formal',   'icon' => '👞', 'bg' => 'from-gray-600 to-gray-800'],
                        ['nama' => 'Boots',    'icon' => '🥾', 'bg' => 'from-orange-400 to-orange-600'],
                    ];
                @endphp

                @foreach($kategori as $k)
                    <a href="#" class="bg-gradient-to-br {{ $k['bg'] }} rounded-xl p-6 text-white text-center hover:scale-105 transition-transform">
                        <div class="text-4xl mb-2">{{ $k['icon'] }}</div>
                        <p class="font-semibold">{{ $k['nama'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Produk Terbaru --}}
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">Produk Terbaru</h2>
                <a href="#" class="text-sm text-blue-600 hover:underline">Lihat semua</a>
            </div>

            @php
                $produk = [
                    ['nama' => 'Nike Air Max 270',  'harga' => 1500000, 'rating' => 4.8, 'terjual' => 120],
                    ['nama' => 'Adidas Ultraboost', 'harga' => 1850000, 'rating' => 4.9, 'terjual' => 95],
                    ['nama' => 'Puma RS-X',         'harga' => 1200000, 'rating' => 4.7, 'terjual' => 78],
                    ['nama' => 'Converse Chuck',    'harga' => 750000,  'rating' => 4.6, 'terjual' => 200],
                ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($produk as $p)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                        <div class="h-40 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center relative">
                            <span class="text-6xl group-hover:scale-110 transition-transform">👟</span>
                            <button class="absolute top-2 right-2 w-8 h-8 bg-white rounded-full shadow flex items-center justify-center text-gray-400 hover:text-red-500">
                                <i class="fas fa-heart text-sm"></i>
                            </button>
                        </div>
                        <div class="p-3">
                            <h3 class="font-semibold text-sm text-gray-800 truncate">{{ $p['nama'] }}</h3>
                            <div class="flex items-center gap-1 mt-1 text-xs text-gray-500">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span>{{ $p['rating'] }}</span>
                                <span>·</span>
                                <span>{{ $p['terjual'] }} terjual</span>
                            </div>
                            <p class="text-blue-600 font-bold mt-2">
                                Rp {{ number_format($p['harga'], 0, ',', '.') }}
                            </p>
                            <button class="w-full mt-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-2 rounded-lg transition">
                                <i class="fas fa-cart-plus mr-1"></i> Keranjang
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </main>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-sm text-gray-500">
            © {{ date('Y') }} Toko Sepatu. All rights reserved.
        </div>
    </footer>

</body>
</html>