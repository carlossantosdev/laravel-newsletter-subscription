<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\CustomAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(CustomAuth::class)->group(function () {
    Route::post('/users', [UserController::class, 'store']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
