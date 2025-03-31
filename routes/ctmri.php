<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Debtor\ctmri;
use App\Http\Controllers\Creditor\ct;
use App\Http\Controllers\Creditor\transaction;

Route::prefix('ctmri')->group(function () {
    Route::get('', [ctmri::class, 'index'])->middleware(['auth', 'verified'])->name('ctmri.index');
    Route::post('ctmri-import', [ctmri::class, 'import'])->middleware(['auth', 'verified'])->name('ctmri.import');
    Route::get('list', [ctmri::class, 'list'])->middleware(['auth', 'verified'])->name('ctmri.list');
    Route::get('search', [ctmri::class, 'search'])->middleware(['auth', 'verified'])->name('ctmri.search');
    Route::get('send', [ctmri::class, 'send'])->middleware(['auth', 'verified'])->name('ctmri.send');
    Route::get('hospital', [ctmri::class, 'hospital'])->middleware(['auth', 'verified'])->name('ctmri.hospital');
    Route::get('hospital/search/month', [ctmri::class, 'hospitalSearch'])->middleware(['auth', 'verified'])->name('ctmri.hospital.month');
    Route::get('hospital/{id}/month/{month}', [ctmri::class, 'hospitalList'])->middleware(['auth', 'verified'])->name('ctmri.hospital.list');
    Route::get('paid', [ctmri::class, 'paid'])->middleware(['auth', 'verified'])->name('ctmri.paid');
});

Route::prefix('credit/ct')->group(function () {
    Route::get('', [ct::class, 'index'])->middleware(['auth', 'verified'])->name('ct.index');
    Route::get('hospital', [ct::class, 'hospital'])->middleware(['auth', 'verified'])->name('ct.hospital');
    Route::get('hospital/{id}', [ct::class, 'hospital_view'])->middleware(['auth', 'verified'])->name('ct.hospital.view');
    Route::get('list/{id}', [ct::class, 'list'])->middleware(['auth', 'verified'])->name('ct.list');
    Route::get('list/confirm/{id}/ct_status/{ct_status}', [ct::class, 'list_confirm'])->middleware(['auth', 'verified'])->name('ct.list.confirm');
    Route::get('list/transaction/create', [ct::class, 'transaction_create'])->middleware(['auth', 'verified'])->name('ct.transaction.create');
});

Route::prefix('transaction/ct')->group(function () {
    Route::get('', [transaction::class, 'index'])->middleware(['auth', 'verified'])->name('transaction.index');
    Route::get('{id}', [transaction::class, 'view'])->middleware(['auth', 'verified'])->name('transaction.view');
    Route::post('upload/{id}', [transaction::class, 'upload'])->middleware(['auth', 'verified'])->name('transaction.upload');
});