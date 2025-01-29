<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\TransactionController;
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
        Route::prefix('master')->group(function () {
            // Tax
            Route::controller(TaxController::class)->group(function () {
                Route::get('/tax', 'index')->name('tax.index');
                Route::get('/tax/list', 'getAll')->name('tax.getAll');
                Route::post('/tax', 'store')->name('tax.store');
                Route::get('/tax/{tax}', 'show')->name('tax.show');
                Route::put('/tax/{tax}', 'update')->name('tax.update');
                Route::delete('/tax/{tax}', 'destroy')->name('tax.destroy');
            });

            // Unit
            Route::controller(UnitController::class)->group(function () {
                Route::get('/unit', 'index')->name('unit.index');
                Route::get('/unit/list', 'getAll')->name('unit.getAll');
                Route::post('/unit', 'store')->name('unit.store');
                Route::get('/unit/{unit}', 'show')->name('unit.show');
                Route::put('/unit/{unit}', 'update')->name('unit.update');
                Route::delete('/unit/{unit}', 'destroy')->name('unit.destroy');
            });

            // Payment Type
            Route::controller(PaymentTypeController::class)->group(function () {
                Route::get('/payment-type', 'index')->name('paymentType.index');
                Route::get('/payment-type/list', 'getAll')->name('paymentType.getAll');
                Route::post('/payment-type', 'store')->name('paymentType.store');
                Route::get('/payment-type/{paymentType}', 'show')->name('paymentType.show');
                Route::put('/payment-type/{paymentType}', 'update')->name('paymentType.update');
                Route::delete('/payment-type/{paymentType}', 'destroy')->name('paymentType.destroy');
            });

            // Supplier
            Route::controller(SupplierController::class)->group(function () {
                Route::get('/supplier', 'index')->name('supplier.index');
                Route::get('/supplier/create', 'createview')->name('supplier.create');
                Route::get('/supplier/view/{supplier}', 'detailview')->name('supplier.detail');
                Route::get('/supplier/list', 'getAll')->name('supplier.getAll');
                Route::post('/supplier', 'store')->name('supplier.store');
                Route::get('/supplier/{supplier}', 'show')->name('supplier.show');
                Route::put('/supplier/{supplier}', 'update')->name('supplier.update');
                Route::delete('/supplier/{supplier}', 'destroy')->name('supplier.destroy');
            });
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

            // Product
            Route::controller(ProductController::class)->group(function () {
                Route::get('/product', 'index')->name('product.index');
                Route::get('/product/create', 'createview')->name('product.create');
                Route::get('/product/view/{product}', 'detailview')->name('product.edit');
                Route::get('/product/list', 'getAll')->name('product.getAll');
                Route::post('/product', 'store')->name('product.store');
                Route::get('/product/{product}', 'show')->name('product.show');
                Route::put('/product/{product}', 'update')->name('product.update');
                Route::delete('/product/{product}', 'destroy')->name('product.destroy');
            });
        });

        // Transaksi
        Route::prefix('transaction')->group(function () {
            // Purchase Order
            Route::controller(PurchaseOrderController::class)->group(function () {
                Route::get('/purchase-order', 'index')->name('purchaseOrder.index');
                Route::get('/purchase-order/create', 'createview')->name('purchaseOrder.create');
                Route::get('/purchase-order/view/{purchaseOrder}', 'detailview')->name('purchaseOrder.edit');
                Route::get('/purchase-order/list', 'getAll')->name('purchaseOrder.getAll');
                Route::post('/purchase-order', 'store')->name('purchaseOrder.store');
                Route::get('/purchase-order/{purchaseOrder}', 'show')->name('purchaseOrder.show');
                Route::post('/purchase-order/{purchaseOrder}/payment', 'updatePaymentStatus')->name('purchaseOrder.updatePaymentStatus');
            });
        });
    });

// POS Routes (Both Admin and Kasir)
Route::prefix('pos')
    ->middleware(['auth', KasirMiddleware::class])
    ->group(function () {
        Route::controller(PosController::class)->group(function () {
            Route::get('/', 'index')->name('pos.index');
            Route::get('/receipt', function () {
                return view('pages.pos.receipt');
            })->name('pos.receipt');

            Route::prefix('recipe')->group(function () {
                // Recipe
                Route::controller(RecipeController::class)->group(function () {
                    Route::get('/list', 'getAll')->name('recipe.getAll');
                    Route::post('', 'store')->name('recipe.store');
                    Route::get('{recipe}', 'show')->name('recipe.show');
                });
            });

            Route::prefix('transaction')->group(function () {
                // Transaction
                Route::controller(TransactionController::class)->group(function () {
                    Route::get('/list', 'getAll')->name('transaction.getAll');
                    Route::post('', 'store')->name('transaction.store');
                    Route::get('{transaction}', 'show')->name('transaction.show');
                });
            });
        });
    });
