<?php

use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\AlumniController;
use App\Http\Controllers\Web\Admin\GeneralInformationController;
use App\Http\Controllers\Web\Admin\InformationCategoryController;
use App\Http\Controllers\Web\Admin\InformationController;
use App\Http\Controllers\Web\Admin\OutstandingAlumniController;
use App\Http\Controllers\Web\Alumni\DashboardController as AlumniDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\UserGuest\LandingController;
use Phiki\Phast\Root;

Route::get('/', [LandingController::class, 'index'])->name('index');
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
    Route::get('/register', [AuthController::class, 'alumniValidateDataView'])->name('alumni.validate-data.view');
    Route::post('/register', [AuthController::class, 'alumniValidateData'])->name('alumni.validate-data');
    Route::get('/verify-otp', [AuthController::class, 'alumniVerifyOtpView'])->name('alumni.verify-otp.view');
    Route::post('/verify-otp', [AuthController::class, 'alumniVerifyOtp'])->name('alumni.verify-otp');
    Route::get('/complete-profile', [AuthController::class, 'alumniCompleteProfileView'])->name('alumni.complete-profile.view');
    Route::post('/complete-profile', [AuthController::class, 'alumniCompleteProfile'])->name('alumni.complete-profile');
    Route::get('/registration-success', [AuthController::class, 'alumniRegistrationSuccess'])->name('alumni.registration-success');
    Route::get('/login', [AuthController::class, 'alumniLoginView'])->name('alumni.login.view');
    Route::post('/login', [AuthController::class, 'alumniLogin'])->name('alumni.login');
    Route::get('/forgot-password', [AuthController::class, 'alumniForgetPasswordView'])->name('alumni.forgot-password-view');
    Route::post('/forgot-password', [AuthController::class, 'alumniForgetPassword'])->name('alumni.forgot-password');
    Route::get('/verify-forgot-password-otp', [AuthController::class, 'alumniVerifyForgotPasswordOtpView'])->name('alumni.verify-forgot-password-otp-view');
    Route::post('/verify-forgot-password-otp', [AuthController::class, 'alumniVerifyForgotPasswordOtp'])->name('alumni.verify-forgot-password-otp');
    Route::get('/reset-password', [AuthController::class, 'alumniResetPasswordView'])->name('alumni.reset-password-view');
    Route::post('/reset-password', [AuthController::class, 'alumniResetPassword'])->name('alumni.reset-password');
    Route::post('/logout', [AuthController::class, 'logout'])->name('alumni.logout');
});

Route::prefix('alumni')->middleware('alumni')->group(function () {
    Route::get('/', [AlumniDashboardController::class, 'index'])->name('alumni.dashboard.index');
    Route::get('/profile', [AlumniDashboardController::class, 'profile'])->name('alumni.profile');
    Route::get('/change-password', [AlumniDashboardController::class, 'changePasswordView'])->name('alumni.change-password-view');
    Route::post('/change-password', [AlumniDashboardController::class, 'changePassword'])->name('alumni.change-password');

    // Educational Backgrounds
    Route::get('/educational-backgrounds', [AlumniDashboardController::class, 'educationalBackgrounds'])->name('alumni.educational-backgrounds');
    Route::get('/educational-backgrounds/create', [AlumniDashboardController::class, 'createEducationalBackground'])->name('alumni.educational-backgrounds.create');
    Route::post('/educational-backgrounds', [AlumniDashboardController::class, 'storeEducationalBackground'])->name('alumni.educational-backgrounds.store');
    Route::get('/educational-backgrounds/{id}/edit', [AlumniDashboardController::class, 'editEducationalBackground'])->name('alumni.educational-backgrounds.edit');
    Route::put('/educational-backgrounds/{id}', [AlumniDashboardController::class, 'updateEducationalBackground'])->name('alumni.educational-backgrounds.update');
    Route::delete('/educational-backgrounds/{id}', [AlumniDashboardController::class, 'destroyEducationalBackground'])->name('alumni.educational-backgrounds.destroy');

    // Careers
    Route::get('/careers', [AlumniDashboardController::class, 'careers'])->name('alumni.careers');
    Route::get('/careers/create', [AlumniDashboardController::class, 'createCareer'])->name('alumni.careers.create');
    Route::post('/careers', [AlumniDashboardController::class, 'storeCareer'])->name('alumni.careers.store');
    Route::get('/careers/{id}/edit', [AlumniDashboardController::class, 'editCareer'])->name('alumni.careers.edit');
    Route::put('/careers/{id}', [AlumniDashboardController::class, 'updateCareer'])->name('alumni.careers.update');
    Route::delete('/careers/{id}', [AlumniDashboardController::class, 'destroyCareer'])->name('alumni.careers.destroy');
});
