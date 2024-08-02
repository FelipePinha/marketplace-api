<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{user}/orders', [UserController::class, 'showOrders']);
    Route::post('/user/orders/create', [UserController::class, 'storeOrder']);

    Route::post('/logout/{user}', [AuthController::class, 'logout']);

    Route::post('/products/create', [ProductController::class, 'store']);
    Route::patch('/products/{product}/update', [ProductController::class, 'update']);
    Route::delete('/products/delete/{product}', [ProductController::class, 'destroy']);
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

