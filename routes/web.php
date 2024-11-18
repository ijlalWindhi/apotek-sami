<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\RegisterUserController;

// Auth
Route::prefix('auth')->group(function () {
    // Login
    Route::controller(LoginUserController::class)->group(function () {
        Route::get('/login', 'index')->name('login.index');
        Route::post('/login', 'login')->name('login.store');
    });

    // Register
    Route::controller(RegisterUserController::class)->group(function () {
        Route::get('/register', 'index')->name('register.index');
        Route::post('/register', 'register')->name('register.store');
    });
});

// Inventory
Route::prefix('inventory')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return view('pages.inventory.dashboard', ['title' => 'Dashboard']);
    })->name('inventory.dashboard');

    // Master
    // Tax
    Route::prefix('master')->group(function () {
        Route::controller(TaxController::class)->group(function () {
            Route::get('/tax', 'index')->name('tax.index');
            Route::get('/tax/list', 'getAll')->name('tax.getAll');
            Route::post('/tax', 'store')->name('tax.store');
            Route::get('/tax/{tax}', 'show')->name('tax.show');
            Route::put('/tax/{tax}', 'update')->name('tax.update');
            Route::delete('/tax/{tax}', 'destroy')->name('tax.destroy');
        });
    });

    Route::get('/master/unit', function () {
        return view('pages.inventory.master.unit', ['title' => 'Master Unit Satuan']);
    });

    Route::get('/master/payment-type', function () {
        return view('pages.inventory.master.payment-type', ['title' => 'Master Tipe Pembayaran']);
    });

    Route::get('/master/adjustment-type', function () {
        return view('pages.inventory.master.adjustment-type', ['title' => 'Master Tipe Penyesuaian']);
    });

    // Transaksi
    Route::get('/transaction', function () {
        return view('pages.transaction', ['title' => 'Transaksi']);
    });
});

// POS
Route::prefix('pos')->group(function () {
    Route::get('/', function () {
        return view('pages.pos.index', ['title' => 'POS']);
    })->name('pos.index');
});
