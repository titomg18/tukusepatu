<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Toko</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Profil Toko</h1>
                <p class="text-sm text-gray-500">Kelola informasi tokomu</p>
            </div>
            <a href="{{ route('penjual.dashboard') }}" class="text-sm text-blue-600 hover:underline">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4 pb-6 border-b">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr(Auth::user()->nama_user, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-bold text-gray-800 text-lg">{{ Auth::user()->nama_user }}</h2>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                    <span class="inline-flex items-center gap-1 mt-1 text-xs bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full font-medium">
                        <i class="fas fa-store"></i> Penjual
                    </span>
                </div>
            </div>

            <div class="mt-6 space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Terdaftar sejak</span>
                    <span class="font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse(Auth::user()->tgl_daftar)->translatedFormat('d F Y') }}
                    </span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Status Akun</span>
                    <span class="font-medium text-green-600 capitalize">{{ Auth::user()->status_user }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-500">Role</span>
                    <span class="font-medium text-gray-800 capitalize">{{ Auth::user()->role }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>