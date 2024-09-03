<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;

Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');

Route::middleware('auth:api')->group(function () {
    // Route::get('/me', function (Request $request) {
    //     return $request->user();
    // });
    Route::get('/me', [UserController::class, 'me'])->name('me');

    Route::apiResource('user', UserController::class);
});
