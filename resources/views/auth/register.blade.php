<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Toko Sepatu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 to-indigo-600 min-h-screen flex items-center justify-center p-4">

<div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8">
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">👟 Toko Sepatu</h1>
        <p class="text-gray-500 mt-1">Buat akun baru</p>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama_user" value="{{ old('nama_user') }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Daftar Sebagai</label>
            <div class="flex gap-4">
                <label class="flex-1 cursor-pointer">
                    <input type="radio" name="role" value="pembeli" class="peer hidden"
                           {{ old('role') == 'pembeli' ? 'checked' : '' }} required>
                    <div class="border-2 border-gray-300 rounded-lg py-2 text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-semibold transition">
                        🛍️ Pembeli
                    </div>
                </label>
                <label class="flex-1 cursor-pointer">
                    <input type="radio" name="role" value="penjual" class="peer hidden"
                           {{ old('role') == 'penjual' ? 'checked' : '' }}>
                    <div class="border-2 border-gray-300 rounded-lg py-2 text-center peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 font-semibold transition">
                        🏪 Penjual
                    </div>
                </label>
            </div>
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">
            Daftar
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-6">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Login di sini</a>
    </p>
</div>

</body>
</html>