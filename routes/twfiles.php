<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Debtor\twfiles;

Route::prefix('twfiles')->group(function () {
    Route::get('/', [twfiles::class, 'index'])->middleware(['auth', 'verified'])->name('twfiles.index');
    Route::get('/view/{table}', [twfiles::class, 'view'])->middleware(['auth', 'verified'])->name('twfiles.view');
    Route::post('files-import', [twfiles::class, 'import'])->middleware(['auth', 'verified'])->name('twfiles.import');
});