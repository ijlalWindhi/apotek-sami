<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaxController;

// Inventory
Route::prefix('inventory')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return view('pages.dashboard', ['title' => 'Dashboard']);
    });

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
        return view('pages.master.unit', ['title' => 'Master Unit Satuan']);
    });

    Route::get('/master/payment-type', function () {
        return view('pages.master.payment-type', ['title' => 'Master Tipe Pembayaran']);
    });

    Route::get('/master/adjustment-type', function () {
        return view('pages.master.adjustment-type', ['title' => 'Master Tipe Penyesuaian']);
    });

    // Transaksi
    Route::get('/transaction', function () {
        return view('pages.transaction', ['title' => 'Transaksi']);
    });
});
