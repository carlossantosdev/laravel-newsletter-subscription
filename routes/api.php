<?php

use App\Http\Controllers\InterestController;
use App\Http\Controllers\SubscribeInterestController;
use App\Http\Controllers\TouchInterestController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CustomAuth;
use Illuminate\Support\Facades\Route;

Route::post('/subscribe/interest', SubscribeInterestController::class);
Route::post('/touch/{interest}', TouchInterestController::class);

Route::middleware(CustomAuth::class)->group(function () {
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/interests', [InterestController::class, 'store']);
});
