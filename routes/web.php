<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tax as TaxController;
use App\Models\Tax;

// Penyimpanan - Dashboard
Route::get('/', function () {
    return view('pages.dashboard', ['title' => 'Dashboard']);
});

// Penyimpanan - Master
// Master Tax
Route::get('/master/tax', [TaxController::class, 'index'])->name('tax.index');
Route::post('/master/tax', [TaxController::class, 'create'])->name('tax.create');
Route::get('/master/tax/{tax}', [TaxController::class, 'show'])->name('tax.show');
Route::put('/master/tax/{tax}', [TaxController::class, 'update'])->name('tax.update');
Route::delete('/master/tax/{tax}', [TaxController::class, 'destroy'])->name('tax.destroy');
Route::post('/master/tax/search', [TaxController::class, 'search'])->name('tax.search');

Route::get('/master/unit', function () {
    return view('pages.master.unit', ['title' => 'Master Unit Satuan']);
});

Route::get('/master/payment-type', function () {
    return view('pages.master.payment-type', ['title' => 'Master Tipe Pembayaran']);
});

Route::get('/master/adjustment-type', function () {
    return view('pages.master.adjustment-type', ['title' => 'Master Tipe Penyesuaian']);
});

// Penyimpanan - Transaksi
Route::get('/transaction', function () {
    return view('pages.transaction', ['title' => 'Transaksi']);
});