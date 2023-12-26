<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Route;

auth()->loginUsingId(1);
Route::get("/", fn () => redirect("/dashboard"))->name("home");

Route::get('/dashboard', Pages\Dashboard::class);

// orders
Route::get('/orders', Pages\Orders\Index::class);
Route::get('/orders/{id}', Pages\Orders\Show::class);
