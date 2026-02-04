<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AuthWebController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'index'])->name('products.index');
Route::get('/categories', [HomeController::class, 'categories'])->name('categories.index');
Route::get('/products/{product}', [HomeController::class, 'show'])->name('products.show');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthWebController::class, 'login']);
    Route::get('/register', [AuthWebController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthWebController::class, 'register']);
});

Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Account Settings
    Route::get('/settings', [AuthWebController::class, 'settings'])->name('settings');
    Route::patch('/settings/profile', [AuthWebController::class, 'updateProfile'])->name('settings.profile');
    Route::patch('/settings/password', [AuthWebController::class, 'updatePassword'])->name('settings.password');

    // Cart Management
    Route::prefix('cart')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\CartWebController::class, 'index'])->name('cart.index');
        Route::post('/items', [\App\Http\Controllers\Web\CartWebController::class, 'addItem'])->name('cart.add');
        Route::patch('/items/{itemId}', [\App\Http\Controllers\Web\CartWebController::class, 'updateQuantity'])->name('cart.update');
        Route::delete('/items/{itemId}', [\App\Http\Controllers\Web\CartWebController::class, 'removeItem'])->name('cart.remove');
    });

    Route::post('/checkout', [\App\Http\Controllers\Web\CartWebController::class, 'checkout'])->name('checkout');

    // Order Management (Buyer)
    Route::get('/orders', [\App\Http\Controllers\Web\OrderWebController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Web\OrderWebController::class, 'show'])->name('orders.show');

    // Seller Dashboard
    Route::prefix('seller')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Web\SellerWebController::class, 'dashboard'])->name('seller.dashboard');
        Route::get('/products', [\App\Http\Controllers\Web\SellerWebController::class, 'products'])->name('seller.products');
        Route::get('/products/create', [\App\Http\Controllers\Web\SellerWebController::class, 'createProduct'])->name('seller.products.create');
        Route::post('/products', [\App\Http\Controllers\Web\SellerWebController::class, 'storeProduct'])->name('seller.products.store');
        Route::get('/products/{product}/edit', [\App\Http\Controllers\Web\SellerWebController::class, 'editProduct'])->name('seller.products.edit');
        Route::patch('/products/{product}', [\App\Http\Controllers\Web\SellerWebController::class, 'updateProduct'])->name('seller.products.update');
        Route::post('/products/{product}/publish', [\App\Http\Controllers\Web\SellerWebController::class, 'publishProduct'])->name('seller.products.publish');
        Route::get('/orders', [\App\Http\Controllers\Web\SellerWebController::class, 'orders'])->name('seller.orders');
        Route::patch('/orders/{order}/status', [\App\Http\Controllers\Web\SellerWebController::class, 'updateOrderStatus'])->name('seller.orders.status');
    });

    // Admin Panel
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Web\AdminWebController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [\App\Http\Controllers\Web\AdminWebController::class, 'users'])->name('admin.users');
        Route::get('/products', [\App\Http\Controllers\Web\AdminWebController::class, 'products'])->name('admin.products');
        Route::patch('/products/{product}/status', [\App\Http\Controllers\Web\AdminWebController::class, 'updateProductStatus']);
        Route::post('/users/{user}/toggle', [\App\Http\Controllers\Web\AdminWebController::class, 'toggleUserStatus'])->name('admin.users.toggle');
        Route::post('/sellers/{seller}/approve', [\App\Http\Controllers\Web\AdminWebController::class, 'approveSeller'])->name('admin.sellers.approve');
    });
});
