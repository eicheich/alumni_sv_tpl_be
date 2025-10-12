<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// route group
Route::prefix('v1')->group(function () {
    Route::get('users/', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'specifiedUser']);

    });
