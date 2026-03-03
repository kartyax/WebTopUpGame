<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopUpController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;

Route::get('/', [TopUpController::class, 'index'])->name('home');
Route::get('/topup/{slug}', [TopUpController::class, 'show'])->name('topup.show');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/invoice/{invoice}', [OrderController::class, 'invoice'])->name('order.invoice');
Route::post('/invoice/{invoice}/simulate-pay', [OrderController::class, 'simulatePay'])->name('order.simulate-pay');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
