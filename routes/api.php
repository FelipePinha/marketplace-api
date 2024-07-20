<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function() {
    Route::get('/user', 'index')->middleware('auth:sanctum');
});

Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register');
    Route::post('/logout/{user}', 'logout')->middleware('auth:sanctum');
});

Route::controller(ProductController::class)->group(function() {
    Route::get('/products', 'index');
    Route::post('/products/create', 'store');
});

Route::controller(OrdersController::class)->group(function() {
    Route::get('/orders/{user}', 'index');
    Route::post('/orders/create', 'store');
});