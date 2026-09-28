<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjual - Toko Sepatu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- ============ NAVBAR PENJUAL ============ --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                {{-- Logo + Badge --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('penjual.dashboard') }}" class="flex items-center gap-2">
                        <span class="text-2xl">🏪</span>
                        <div>
                            <span class="font-bold text-lg text-gray-800 block leading-none">Toko Sepatu</span>
                            <span class="text-xs text-orange-600 font-semibold">Panel Penjual</span>
                        </div>
                    </a>
                </div>

                {{-- Menu Tengah --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('penjual.dashboard') }}" class="text-sm font-medium text-blue-600 border-b-2 border-blue-600 pb-1">
                        Dashboard
                    </a>
                    <a href="{{ route('penjual.produk') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">
                        Produk
                    </a>
                    <a href="{{ route('penjual.pesanan') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">
                        Pesanan
                    </a>
                    <a href="{{ route('penjual.toko') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">
                        Toko Saya
                    </a>
                </div>

                {{-- Kanan --}}
                <div class="flex items-center gap-4">
                    <a href="#" class="relative text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 w-2.5 h-2.5 rounded-full"></span>
                    </a>

                    {{-- Profil Dropdown --}}
                    <div class="relative group">
                        <button class="flex items-center gap-2 focus:outline-none">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->nama_user, 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-gray-700 leading-none">{{ Auth::user()->nama_user }}</p>
                                <p class="text-xs text-gray-400">Penjual</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>

                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('penjual.toko') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-store w-4"></i> Profil Toko
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog w-4"></i> Pengaturan
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

        {{-- ===== Header Welcome ===== --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard Penjual</h1>
                <p class="text-gray-500 text-sm mt-1">Selamat datang, <b>{{ Auth::user()->nama_user }}</b>! Kelola tokomu di sini.</p>
            </div>
            <a href="{{ route('penjual.produk') }}"
               class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-lg transition shadow-sm">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>

        {{-- ===== Statistik Utama ===== --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            {{-- Total Pendapatan --}}
            <div class="bg-gradient-to-br from-orange-500 to-red-500 rounded-xl p-5 text-white shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <i class="fas fa-wallet text-2xl opacity-80"></i>
                    <span class="text-xs bg-white/20 px-2 py-0.5 rounded-full">Bulan ini</span>
                </div>
                <p class="text-xs opacity-90">Total Pendapatan</p>
                <p class="text-2xl font-bold mt-1">Rp 0</p>
            </div>

            {{-- Total Produk --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shoe-prints text-blue-600"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">0</p>
            </div>

            {{-- Pesanan Masuk --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-bag text-yellow-600"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500">Pesanan Masuk</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">0</p>
            </div>

            {{-- Rating Toko --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-star text-green-600"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500">Rating Toko</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">-</p>
            </div>
        </div>

        {{-- ===== Grid Dua Kolom: Pesanan Terbaru + Stok Menipis ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            {{-- Pesanan Terbaru --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between p-5 border-b">
                    <div>
                        <h2 class="font-bold text-gray-800">Pesanan Terbaru</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Pesanan yang baru masuk</p>
                    </div>
                    <a href="{{ route('penjual.pesanan') }}" class="text-sm text-blue-600 hover:underline">Lihat semua</a>
                </div>

                <div class="p-5">
                    {{-- Empty state --}}
                    <div class="text-center py-10">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 text-sm font-medium">Belum ada pesanan masuk</p>
                        <p class="text-gray-400 text-xs mt-1">Pesanan dari pembeli akan muncul di sini</p>
                    </div>
                </div>
            </div>

            {{-- Stok Menipis --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between p-5 border-b">
                    <div>
                        <h2 class="font-bold text-gray-800">Stok Menipis</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Perlu di-restock</p>
                    </div>
                    <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                </div>

                <div class="p-5">
                    <div class="text-center py-10">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 text-sm font-medium">Semua stok aman</p>
                        <p class="text-gray-400 text-xs mt-1">Produk dengan stok &lt; 5 akan muncul di sini</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Produk Saya ===== --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between p-5 border-b">
                <div>
                    <h2 class="font-bold text-gray-800">Produk Saya</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola produk yang kamu jual</p>
                </div>
                <a href="{{ route('penjual.produk') }}" class="text-sm text-blue-600 hover:underline">Kelola produk</a>
            </div>

            <div class="p-5">
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shoe-prints text-orange-400 text-3xl"></i>
                    </div>
                    <p class="text-gray-700 font-semibold">Belum ada produk</p>
                    <p class="text-gray-400 text-sm mt-1 mb-4">Mulai jual sepatu pertamamu sekarang!</p>
                    <a href="{{ route('penjual.produk') }}"
                       class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold px-5 py-2 rounded-lg transition">
                        <i class="fas fa-plus"></i> Tambah Produk Pertama
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== Tips Penjual ===== --}}
        <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-lightbulb text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">Tips Meningkatkan Penjualan</h3>
                    <ul class="text-sm text-gray-600 mt-2 space-y-1 list-disc list-inside">
                        <li>Upload foto produk dengan kualitas tinggi dan pencahayaan yang baik</li>
                        <li>Berikan deskripsi yang detail: bahan, ukuran, dan kondisi sepatu</li>
                        <li>Respon pesanan dengan cepat agar rating toko meningkat</li>
                        <li>Update stok secara berkala untuk menghindari pesanan yang tidak bisa diproses</li>
                    </ul>
                </div>
            </div>
        </div>

    </main>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-sm text-gray-500">
            © {{ date('Y') }} Toko Sepatu — Panel Penjual
        </div>
    </footer>

</body>
</html>