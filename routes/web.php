<?php

use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\AlumniController;
use App\Http\Controllers\Web\Admin\GeneralInformationController;
use App\Http\Controllers\Web\Admin\InformationCategoryController;
use App\Http\Controllers\Web\Admin\InformationController;
use App\Http\Controllers\Web\Admin\OutstandingAlumniController;
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

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        Route::prefix('alumni')->group(function () {
            Route::get('/', [AlumniController::class, 'index'])->name('admin.alumni.index');
            Route::get('/{id}', [AlumniController::class, 'show'])->name('admin.alumni.show');
            Route::get('/{id}/edit', [AlumniController::class, 'edit'])->name('admin.alumni.edit');
            Route::post('/store-alumni', [AlumniController::class, 'addAlumni'])->name('admin.alumni.store');
            Route::put('/{id}', [AlumniController::class, 'update'])->name('admin.alumni.update');
            Route::delete('/{id}', [AlumniController::class, 'destroy'])->name('admin.alumni.destroy');
        });
        Route::prefix('informasi')->group(function () {
            Route::get('/', [InformationController::class, 'index'])->name('admin.information.index');
            Route::get('/show/{id}', [InformationController::class, 'show'])->name('admin.information.show');
            Route::post('/store-information', [InformationController::class, 'storeInformation'])->name('admin.information.store');
            Route::get('/{id}/edit', [InformationController::class, 'editInformation'])->name('admin.information.edit');
            Route::post('/{id}/update', [InformationController::class, 'updateInformation'])->name('admin.information.update');
            Route::delete('/{id}', [InformationController::class, 'deleteInformation'])->name('admin.information.destroy');
            Route::post('/gallery', [InformationController::class, 'storeGallery'])->name('admin.information.gallery.store');
            Route::delete('/gallery/{id}', [InformationController::class, 'deleteGallery'])->name('admin.information.gallery.destroy');
            Route::post('category/store', [InformationCategoryController::class, 'storeCategory'])->name('admin.information.category.store');
            Route::put('information-category/{id}/update', [InformationCategoryController::class, 'updateCategory'])->name('admin.information.category.update');
            Route::delete('information-category/{id}/destroy', [InformationCategoryController::class, 'destroyCategory'])->name('admin.information.category.destroy');
        });
        Route::prefix('alumni-berprestasi')->group(function () {
            Route::get('/', [OutstandingAlumniController::class, 'index'])->name('admin.outstanding-alumni.index');
            Route::post('/store', [OutstandingAlumniController::class, 'store'])->name('admin.outstanding-alumni.store');
            Route::get('/{id}/edit', [OutstandingAlumniController::class, 'edit'])->name('admin.outstanding-alumni.edit');
            Route::put('/{id}', [OutstandingAlumniController::class, 'update'])->name('admin.outstanding-alumni.update');
            Route::delete('/{id}', [OutstandingAlumniController::class, 'destroy'])->name('admin.outstanding-alumni.destroy');
        });
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
