<?php

use Illuminate\Support\Facades\Route;

Route::get("/", fn () => redirect(url('dashboard')));
Route::middleware(['storage'])->group(function () {
    Route::get('/storage/private/{path}', \App\Http\Controllers\StorageController::class)
        ->where('path', '.*')
        ->name('storage');
});
