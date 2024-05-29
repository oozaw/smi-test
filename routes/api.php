<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

    // categories
    Route::apiResource('categories', CategoryController::class);

    // products
    Route::apiResource('products', ProductController::class);
    Route::get('/products/search/{keyword}', [ProductController::class, 'search'])->name('products.search');
});
