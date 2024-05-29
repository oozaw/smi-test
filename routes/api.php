<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::group([
    'middleware' => 'api'
], function () {
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
});
