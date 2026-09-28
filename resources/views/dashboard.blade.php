<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow p-8">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="mt-2 text-gray-600">Halo, <b>{{ Auth::user()->nama_user }}</b> 👋</p>
        <p class="text-gray-600">Role: <span class="font-semibold">{{ Auth::user()->role }}</span></p>
        <p class="text-gray-600">Status: <span class="font-semibold">{{ Auth::user()->status_user }}</span></p>

        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                Logout
            </button>
        </form>
    </div>
</body>
</html>