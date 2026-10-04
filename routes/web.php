<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarketplaceController;

Route::get('/', [MarketplaceController::class, 'index'])->name('home');
Route::get('/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['bn', 'en'], true), 404);
    session(['locale' => $locale]);

    return redirect()->back();
})->name('language.switch');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/seller', [MarketplaceController::class, 'sellerDashboard'])->name('seller.dashboard');
    Route::post('/seller/products', [MarketplaceController::class, 'storeProduct'])->name('seller.products.store');
    Route::get('/products/{product}/order', [MarketplaceController::class, 'orderForm'])->name('orders.create');
    Route::post('/products/{product}/order', [MarketplaceController::class, 'storeOrder'])->name('orders.store');
    Route::get('/my-orders', [MarketplaceController::class, 'buyerOrders'])->name('buyer.orders');
});
