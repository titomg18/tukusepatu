<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// ====== Guest ======
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// ====== Pembeli ======
Route::middleware('auth')->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role !== 'pembeli') abort(403);
        return view('pembeli.dashboard');
    })->name('dashboard');
});

// ====== Penjual ======
Route::middleware('auth')->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role !== 'penjual') abort(403);
        return view('penjual.dashboard');
    })->name('dashboard');

    // Placeholder routes — nanti bisa diisi logic
    Route::get('/produk', function () {
        if (Auth::user()->role !== 'penjual') abort(403);
        return view('penjual.produk');
    })->name('produk');

    Route::get('/pesanan', function () {
        if (Auth::user()->role !== 'penjual') abort(403);
        return view('penjual.pesanan');
    })->name('pesanan');

    Route::get('/toko', function () {
        if (Auth::user()->role !== 'penjual') abort(403);
        return view('penjual.toko');
    })->name('toko');
});

// ====== Logout ======
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');