<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\KasirMiddleware;

// Auth Route (accessible when guest)
Route::middleware('guest')->group(function () {
    Route::controller(LoginUserController::class)->group(function () {
        Route::get('/auth/login', 'index')->name('login');
        Route::post('/auth/login', 'login')->name('login.store');
    });
});

// Logout Route (accessible when authenticated)
Route::post('/auth/logout', [LoginUserController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


// Root redirect
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role == '0') {
            return redirect()->route('inventory.dashboard');
        }
        return redirect()->route('pos.index');
    }
    return redirect()->route('login');
});

// Inventory Routes (Admin Only)
Route::prefix('inventory')
    ->middleware(['auth', AdminMiddleware::class])
    ->group(function () {

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

        // Pharmacy
        // Employee
        Route::prefix('pharmacy')->group(function () {
            Route::controller(RegisterUserController::class)->group(function () {
                Route::get('/employee', 'index')->name('employee.index');
                Route::get('/employee/list', 'getAll')->name('employee.getAll');
                Route::post('/employee', 'store')->name('employee.store');
                Route::get('/employee/{user}', 'show')->name('employee.show');
                Route::put('/employee/{user}', 'update')->name('employee.update');
                Route::delete('/employee/{user}', 'destroy')->name('employee.destroy');
            });
        });

        // Transaksi
        Route::get('/transaction', function () {
            return view('pages.transaction', ['title' => 'Transaksi']);
        });
    });

// POS Routes (Both Admin and Kasir)
Route::prefix('pos')
    ->middleware(['auth', KasirMiddleware::class])
    ->group(function () {
        Route::get('/', function () {
            return view('pages.pos.index', ['title' => 'POS']);
        })->name('pos.index');
    });
