<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;

Route::get('/', function () {
    return view('welcome');
});
// prefix admin
Route::prefix('admin')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/register', [AuthController::class, 'registerAdminView'])->name('admin.register.view');
        Route::post('/register', [AuthController::class, 'registerAdmin'])->name('admin.register');
        Route::get('/login', [AuthController::class, 'loginAdminView'])->name('admin.login.view');
        Route::post('/login', [AuthController::class, 'loginAdmin'])->name('admin.login');
    });
});
