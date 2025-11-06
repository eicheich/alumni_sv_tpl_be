<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// route group
Route::prefix('v1')->group(function () {
    Route::prefix('admin')->group(function () {
        // Route::post('/login', [AuthController::class, 'login']);
    });

});
