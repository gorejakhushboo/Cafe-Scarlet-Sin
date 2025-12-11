<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminCheckController;

// Show form
Route::get('/admincheck', [AdminCheckController::class, 'index'])->name('admin.form');

// Process login
Route::post('/admincheck', [AdminCheckController::class, 'login'])->name('admin.login');

// Admin Product Routes
use App\Http\Controllers\ProductAdminController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/products', [ProductAdminController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductAdminController::class, 'create'])->name('products.create');
    // Route::get('/products/create', function() { dd('DEBUG: ROUTE HIJACK SUCCESS'); })->name('products.create');
    Route::post('/products', [ProductAdminController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductAdminController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductAdminController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductAdminController::class, 'destroy'])->name('products.destroy');

    // Admin Category Routes
    Route::resource('categories', \App\Http\Controllers\CategoryAdminController::class);
});

// Homepage and static pages
Route::get('/', function () {
    return view('page1');
})->name('home');

Route::get('/page2', [MenuController::class, 'index'])->name('page2');
Route::get('/products/{product}', [MenuController::class, 'show'])->name('products.show');
Route::get('/page3', function () {
    return view('page3');
})->name('page3');

// Ajax Search
Route::get('/ajax/products/search', [MenuController::class, 'search'])->name('products.search');

// Comments
Route::post('/add-comment', [CommentController::class, 'store'])->name('addComment');

// Cart routes (all form-based, no JavaScript)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/{cartItem}/update', [CartController::class, 'update'])->name('update');
    Route::delete('/{cartItem}', [CartController::class, 'destroy'])->name('destroy');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

// Payment and checkout routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/checkout', [PaymentController::class, 'create'])->name('create');
    Route::post('/process', [PaymentController::class, 'store'])->name('store');
});

// Order routes
Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::post('/{order}/accept', [OrderController::class, 'accept'])->name('accept');
    Route::post('/{order}/ship', [OrderController::class, 'ship'])->name('ship');
    Route::post('/{order}/deliver', [OrderController::class, 'deliver'])->name('deliver');
    Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
});
