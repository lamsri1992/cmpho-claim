<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cmpho\dataController;
use App\Http\Controllers\Cmpho\configController;

Route::prefix('cmpho')->group(function () {
    Route::get('dashboard', [dataController::class, 'index'])->middleware(['auth', 'verified'])->name('cmpho.index');
    // Route::get('report', [dataController::class, 'report'])->middleware(['auth', 'verified'])->name('cmpho.report');
});

Route::prefix('cmpho/opae')->group(function () {
    Route::get('/', [dataController::class, 'opae'])->middleware(['auth', 'verified'])->name('cmpho.opae.index');
    Route::get('process', [dataController::class, 'processOpae'])->middleware(['auth', 'verified'])->name('cmpho.opae.process');
    Route::get('report', [dataController::class, 'reportOpae'])->middleware(['auth', 'verified'])->name('cmpho.opae.report');
});

Route::prefix('cmpho/ctmri')->group(function () {
    Route::get('/', [dataController::class, 'ctmri'])->middleware(['auth', 'verified'])->name('cmpho.ctmri.index');
    Route::get('process', [dataController::class, 'processCtmri'])->middleware(['auth', 'verified'])->name('cmpho.ctmri.process');
});

Route::prefix('cmpho/config')->group(function () {
    Route::get('hospital', [configController::class, 'hospital'])->middleware(['auth', 'verified'])->name('config.hospital');
    Route::post('hospital/create', [configController::class, 'hospitalCreate'])->middleware(['auth', 'verified'])->name('config.hospital.create');
    Route::get('users', [configController::class, 'users'])->middleware(['auth', 'verified'])->name('config.users');
    Route::post('user/create', [configController::class, 'userCreate'])->middleware(['auth', 'verified'])->name('config.user.create');
    Route::get('nhso', [configController::class, 'nhso'])->middleware(['auth', 'verified'])->name('config.nhso');
    Route::get('status', [configController::class, 'status'])->middleware(['auth', 'verified'])->name('config.nhso.status');
});

Route::prefix('cmpho/setting')->group(function () {
    Route::get('nhso', [configController::class, 'nhso'])->middleware(['auth', 'verified'])->name('config.nhso');
    Route::get('status', [configController::class, 'status'])->middleware(['auth', 'verified'])->name('config.nhso.status');
});