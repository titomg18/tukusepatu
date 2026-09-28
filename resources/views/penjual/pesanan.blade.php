<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Masuk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pesanan Masuk</h1>
                <p class="text-sm text-gray-500">Kelola pesanan dari pembeli</p>
            </div>
            <a href="{{ route('penjual.dashboard') }}" class="text-sm text-blue-600 hover:underline">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-20 h-20 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shopping-bag text-yellow-500 text-3xl"></i>
            </div>
            <p class="text-gray-700 font-semibold">Halaman Pesanan</p>
            <p class="text-gray-400 text-sm mt-1">Fitur kelola pesanan akan dibuat selanjutnya.</p>
        </div>
    </div>
</body>
</html>