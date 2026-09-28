<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualOrderController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ====== Landing Page Publik (Katalog Pembeli / Guest) ======
Route::get('/', function () {
    if (Auth::check() && Auth::user()->role === 'penjual') {
        return redirect()->route('penjual.produk');
    }

    return app(PembeliController::class)->dashboard(request());
})->name('home');

// ====== Guest / Auth (Public Buyer Catalog & Cart) ======
Route::prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::check() && Auth::user()->role === 'penjual') {
            return redirect()->route('penjual.produk');
        }

        return app(PembeliController::class)->dashboard(request());
    })->name('dashboard');

    // Detail Produk Sepatu (Publik)
    Route::get('/produk/{id}', [PembeliController::class, 'showProduct'])->name('produk.detail');

    // Keranjang Belanja Publik (Session)
    Route::get('/keranjang', [PembeliController::class, 'keranjang'])->name('keranjang');
    Route::post('/keranjang/tambah', [PembeliController::class, 'addToCart'])->name('keranjang.add');
    Route::post('/keranjang/update', [PembeliController::class, 'updateCart'])->name('keranjang.update');
    Route::post('/keranjang/hapus', [PembeliController::class, 'removeFromCart'])->name('keranjang.remove');
});

// ====== Guest Only (Login & Register) ======
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// ====== Pembeli Auth Protected (Checkout & Order History) ======
Route::middleware('auth')->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/checkout', [PembeliController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [PembeliController::class, 'processCheckout'])->name('checkout.process');

    Route::get('/pesanan', [PembeliController::class, 'orders'])->name('order.index');
    Route::get('/pesanan/{id}', [PembeliController::class, 'showOrder'])->name('order.show');
    Route::post('/pesanan/{id}/upload-bukti', [PembeliController::class, 'uploadBuktiBayar'])->name('order.upload_bukti');
});

// ====== Penjual Auth Protected ======
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

    // Manajemen Pesanan Masuk Penjual
    Route::get('/pesanan', [PenjualOrderController::class, 'index'])->name('pesanan');
    Route::put('/pesanan/{id}/status', [PenjualOrderController::class, 'updateStatus'])->name('pesanan.update_status');

    Route::get('/toko', function () {
        if (Auth::user()->role !== 'penjual') {
            abort(403);
        }

        return view('penjual.toko');
    })->name('toko');
});

// ====== Logout ======
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
