<?php

use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\AlumniController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use Phiki\Phast\Root;

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
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    });
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    Route::prefix('alumni')->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('admin.alumni.index');
    });
    Route::prefix('auth')->group(function () {
        Route::get('/register', [AuthController::class, 'registerAlumniView'])->name('admin.register.view');
        Route::post('/register', [AuthController::class, 'registerAlumni'])->name('admin.register');
        Route::get('/login', [AuthController::class, 'loginAlumniView'])->name('admin.login.view');
        Route::post('/login', [AuthController::class, 'loginAlumni'])->name('admin.login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    });
    Route::prefix('alumni')->group(function () {
        Route::get('/', [AlumniController::class, 'index'])->name('admin.alumni.index');
        Route::post('/store-alumni', [AlumniController::class, 'addAlumni'])->name('admin.alumni.store');
    });
    Route::prefix('informasi')->group(function () {
        Route::get('/', [Root::class, 'index'])->name('phast.index');
    });
});
Route::prefix('auth')->group(function () {
    Route::get('/register', [AuthController::class, 'alumniValidateDataView'])->name('alumni.validate.view');
    Route::post('/register', [AuthController::class, 'alumniValidateData'])->name('alumni.validate');
    Route::post('/register', [AuthController::class, 'alumniRegister'])->name('alumni.register');
    Route::get('/login', [AuthController::class, 'alumniLoginView'])->name('alumni.login.view');
    Route::post('/login', [AuthController::class, 'alumniLogin'])->name('alumni.login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('alumni.logout');
});
