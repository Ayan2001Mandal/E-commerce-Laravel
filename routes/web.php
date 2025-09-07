<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

// User routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard'); // ✅ now from resources/views/user/dashboard.blade.php
    })->name('user.dashboard');
});


//Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


   // Admin functionalities
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/add-product', [App\Http\Controllers\ProductController::class, 'create'])->name('admin.addProduct');
        Route::post('/admin/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
        Route::get('/admin/view-products', [App\Http\Controllers\ProductController::class, 'view'])->name('admin.viewProduct');
        Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.order');
        Route::post('/admin/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.order.updateStatus');

        Route::get('/admin/products/{id}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
        Route::put('/admin/products/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
        Route::delete('/admin/products/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
    });

    // User functionalities
    Route::middleware(['auth', 'role:user'])->group(function () {

        // Products
            Route::get('/user/dashboard', [UserProductController::class,'dashboard'])->name('user.dashboard');
            // Products by category
            Route::get('/category/{category}', [UserProductController::class, 'byCategory'])->name('products.category');
            // Product details
            Route::get('/product/{id}', [UserProductController::class, 'show'])->name('products.show');
            // All Products
            Route::get('/products', [UserProductController::class, 'allProducts'])->name('products.all');
            // Search Products
            Route::get('/products/search', [UserProductController::class, 'search'])->name('products.search');

        // Cart
            Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
            Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
            Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

        // Orders
            Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
            Route::post('/checkout/place', [OrderController::class, 'placeOrder'])->name('orders.place');
            Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
            Route::get('/buy-now/{id}', [OrderController::class, 'buyNow'])->name('user.buyNow');


        // Address
            Route::post('/address', [AddressController::class, 'store'])->name('address.store');
            Route::delete('/address/{id}', [AddressController::class, 'destroy'])->name('address.destroy');

    });

});


require __DIR__.'/auth.php';
