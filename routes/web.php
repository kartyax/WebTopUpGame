<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrackOrderController;
use Illuminate\Support\Facades\Route;

// ======== PUBLIC ROUTES ========
Route::get('/', [TopUpController::class, 'index'])->name('home');
Route::get('/topup/{slug}', [TopUpController::class, 'show'])->name('topup.show');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/invoice/{invoice}', [OrderController::class, 'invoice'])->name('order.invoice');
Route::post('/invoice/{invoice}/simulate-pay', [OrderController::class, 'simulatePay'])->name('order.simulate-pay');
Route::get('/track', [TrackOrderController::class, 'index'])->name('track.index');
Route::post('/track', [TrackOrderController::class, 'search'])->name('track.search');


// ======== AUTH USER ROUTES ========
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ======== ADMIN ROUTES ========
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Games CRUD
    Route::get('/games', [AdminController::class, 'games'])->name('games');
    Route::get('/games/create', [AdminController::class, 'createGame'])->name('games.create');
    Route::post('/games', [AdminController::class, 'storeGame'])->name('games.store');
    Route::get('/games/{game}/edit', [AdminController::class, 'editGame'])->name('games.edit');
    Route::put('/games/{game}', [AdminController::class, 'updateGame'])->name('games.update');
    Route::delete('/games/{game}', [AdminController::class, 'deleteGame'])->name('games.delete');

    // Products CRUD
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('products.delete');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'orderDetail'])->name('orders.detail');

    // Payment Methods CRUD
    Route::get('/payment-methods', [AdminController::class, 'paymentMethods'])->name('payment-methods');
    Route::get('/payment-methods/create', [AdminController::class, 'createPaymentMethod'])->name('payment-methods.create');
    Route::post('/payment-methods', [AdminController::class, 'storePaymentMethod'])->name('payment-methods.store');
    Route::get('/payment-methods/{method}/edit', [AdminController::class, 'editPaymentMethod'])->name('payment-methods.edit');
    Route::put('/payment-methods/{method}', [AdminController::class, 'updatePaymentMethod'])->name('payment-methods.update');
    Route::delete('/payment-methods/{method}', [AdminController::class, 'deletePaymentMethod'])->name('payment-methods.delete');
});

require __DIR__.'/auth.php';

