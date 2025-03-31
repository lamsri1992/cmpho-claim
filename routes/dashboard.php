<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\dashboard;

Route::prefix('/')->group(function () {
    Route::get('dashboard', [dashboard::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('nhso/list', [dashboard::class, 'nhso'])->middleware(['auth', 'verified'])->name('nhso.list');
    Route::get('nhso/drug', [dashboard::class, 'drug'])->middleware(['auth', 'verified'])->name('nhso.drug');
    Route::get('gpu/drug', [dashboard::class, 'gpu'])->middleware(['auth', 'verified'])->name('gpu.drug');
});