<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\OrderReceiptController;
use App\Http\Controllers\Pembeli\DashboardController as PembeliDashboardController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GateController::class, 'show'])->name('gate');

Route::post('/daftar', [AuthController::class, 'register'])->name('auth.register');
Route::post('/masuk', [AuthController::class, 'login'])->name('auth.login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/masuk', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AdminAuthController::class, 'login'])->name('login.submit');

    Route::middleware(['shop.auth', 'admin'])->group(function () {
        Route::post('/keluar', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengguna', [AdminUserController::class, 'index'])->name('users.index');
        Route::delete('/pengguna/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::get('/produk', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/produk/baru', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/produk', [AdminProductController::class, 'store'])->name('products.store');
        Route::patch('/produk/{product}/toggle', [AdminProductController::class, 'toggle'])->name('products.toggle');
        Route::delete('/produk/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    });
});

Route::middleware(['shop.auth', 'pembeli'])->group(function () {
    Route::post('/keluar', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/dashboard', [PembeliDashboardController::class, 'index'])->name('pembeli.dashboard');

    Route::get('/toko', [ShopController::class, 'index'])->name('toko.index');
    Route::get('/toko/produk/{product}', [ShopController::class, 'show'])->name('toko.show');

    Route::get('/jual/produk/baru', [SellerProductController::class, 'create'])->name('jual.create');
    Route::post('/jual/produk', [SellerProductController::class, 'store'])->name('jual.store');

    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/produk/{product}', [CartController::class, 'add'])->name('keranjang.add');
    Route::patch('/keranjang/{cartItem}', [CartController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{cartItem}', [CartController::class, 'destroy'])->name('keranjang.destroy');

    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/pesanan', [OrderHistoryController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{order}', [OrderHistoryController::class, 'show'])->name('pesanan.show');
    Route::get('/pesanan/{order}/struk', [OrderReceiptController::class, 'show'])->name('pesanan.struk');
});
