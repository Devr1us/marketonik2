<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GateController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\OrderReceiptController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GateController::class, 'show'])->name('gate');

Route::post('/daftar', [AuthController::class, 'register'])->name('auth.register');
Route::post('/masuk', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['shop.auth'])->group(function () {
    Route::post('/keluar', [AuthController::class, 'logout'])->name('auth.logout');

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
