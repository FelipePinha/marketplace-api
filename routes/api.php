<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register');
    Route::post('/logout/{user}', 'logout')->middleware('auth:sanctum');
});

Route::controller(ProductController::class)->group(function() {
    Route::get('/products', 'index');
    Route::post('/products/create', 'store');
});