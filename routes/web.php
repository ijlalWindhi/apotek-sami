<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
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

            Route::controller(UnitController::class)->group(function () {
                Route::get('/unit', 'index')->name('unit.index');
                Route::get('/unit/list', 'getAll')->name('unit.getAll');
                Route::post('/unit', 'store')->name('unit.store');
                Route::get('/unit/{unit}', 'show')->name('unit.show');
                Route::put('/unit/{unit}', 'update')->name('unit.update');
                Route::delete('/unit/{unit}', 'destroy')->name('unit.destroy');
            });
        });

        Route::get('/master/payment-type', function () {
            return view('pages.inventory.master.payment-type', ['title' => 'Master Tipe Pembayaran']);
        });

        Route::get('/master/supplier', function () {
            return view('pages.inventory.master.supplier', ['title' => 'Master Supplier']);
        });

        // Pharmacy
        Route::prefix('pharmacy')->group(function () {
            // Employee
            Route::controller(RegisterUserController::class)->group(function () {
                Route::get('/employee', 'index')->name('employee.index');
                Route::get('/employee/list', 'getAll')->name('employee.getAll');
                Route::post('/employee', 'store')->name('employee.store');
                Route::get('/employee/{user}', 'show')->name('employee.show');
                Route::put('/employee/{user}', 'update')->name('employee.update');
                Route::delete('/employee/{user}', 'destroy')->name('employee.destroy');
            });

            // Doctor
            Route::controller(DoctorController::class)->group(function () {
                // Route::get('/doctor', 'index')->name('doctor.index');
                Route::get('/doctor/list', 'getAll')->name('doctor.getAll');
                Route::post('/doctor', 'store')->name('doctor.store');
                Route::get('/doctor/{user}', 'show')->name('doctor.show');
                Route::put('/doctor/{user}', 'update')->name('doctor.update');
                Route::delete('/doctor/{user}', 'destroy')->name('doctor.destroy');
            });

            // Customer
            Route::controller(CustomerController::class)->group(function () {
                // Route::get('/customer', 'index')->name('customer.index');
                Route::get('/customer/list', 'getAll')->name('customer.getAll');
                Route::post('/customer', 'store')->name('customer.store');
                Route::get('/customer/{user}', 'show')->name('customer.show');
                Route::put('/customer/{user}', 'update')->name('customer.update');
                Route::delete('/customer/{user}', 'destroy')->name('customer.destroy');
            });

            // Product
            Route::controller(ProductController::class)->group(function () {
                Route::get('/product', 'index')->name('product.index');
                Route::get('/product/list', 'getAll')->name('product.getAll');
                Route::post('/product', 'store')->name('product.store');
                Route::get('/product/{product}', 'show')->name('product.show');
                Route::put('/product/{product}', 'update')->name('product.update');
                Route::delete('/product/{product}', 'destroy')->name('product.destroy');
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
