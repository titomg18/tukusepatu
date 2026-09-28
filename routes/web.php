<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
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
        if (Auth::user()->role !== 'pembeli') {
            abort(403);
        }

        return view('pembeli.dashboard');
    })->name('dashboard');
});

// ====== Penjual ======
Route::middleware('auth')->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role !== 'penjual') {
            abort(403);
        }

        return redirect()->route('penjual.produk');
    })->name('dashboard');

    // Manajemen Produk Sepatu
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
    Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('/pesanan', function () {
        if (Auth::user()->role !== 'penjual') {
            abort(403);
        }

        return view('penjual.pesanan');
    })->name('pesanan');

    Route::get('/toko', function () {
        if (Auth::user()->role !== 'penjual') {
            abort(403);
        }

        return view('penjual.toko');
    })->name('toko');
});

// ====== Logout ======
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
