<?php

use App\Http\Controllers\ArchivedOrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes (no registration for customers)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected routes (authenticated employees only)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users: management restricted to the Admin department.
    Route::middleware('department:Admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show', 'destroy']);
    });

    // Orders: available to all authenticated employees.
    Route::get('/orders/archived', [ArchivedOrderController::class, 'index'])->name('orders.archived');
    Route::post('/orders/{order}/restore', [ArchivedOrderController::class, 'restore'])->name('orders.restore');

    Route::resource('orders', OrderController::class)->except(['destroy']);
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
});
