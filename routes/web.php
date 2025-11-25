<?php

use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\AlumniController;
use App\Http\Controllers\Web\Admin\GeneralInformationController;
use App\Http\Controllers\Web\Admin\InformationCategoryController;
use App\Http\Controllers\Web\Admin\InformationController;
use App\Http\Controllers\Web\Admin\OutstandingAlumniController;
use App\Http\Controllers\Web\Alumni\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\UserGuest\LandingController;
use App\Http\Controllers\Web\UserGuest\InformationController as GuestInformationController;
use App\Http\Controllers\Web\UserGuest\OutstandingAlumniController as GuestOutstandingAlumniController;
use App\Http\Controllers\Web\UserGuest\AboutController;
use App\Http\Controllers\Web\UserGuest\FaqController;
use Phiki\Phast\Root;

Route::get('resources/images/{path}', function ($path) {
    $path = resource_path('images/' . $path);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->where('path', '.*');

Route::get('/', [LandingController::class, 'index'])->name('index');
Route::get('/tentang', [AboutController::class, 'index'])->name('about.index');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
// prefix admin
Route::prefix('admin')->group(function () {
    Route::prefix('auth')->group(function () {
        // Login admin hanya lewat /auth/login
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
        Route::prefix('alumni')->group(function () {
            Route::get('/', [AlumniController::class, 'index'])->name('admin.alumni.index');
            Route::post('/export-excel', [AlumniController::class, 'exportExcel'])->name('admin.alumni.exportExcel');
            Route::get('/{encrypted_id}', [AlumniController::class, 'show'])->name('admin.alumni.show');
            Route::get('/{encrypted_id}/edit', [AlumniController::class, 'edit'])->name('admin.alumni.edit');
            Route::post('/store-alumni', [AlumniController::class, 'addAlumni'])->name('admin.alumni.store');
            Route::put('/{encrypted_id}', [AlumniController::class, 'update'])->name('admin.alumni.update');
            Route::delete('/{encrypted_id}', [AlumniController::class, 'destroy'])->name('admin.alumni.destroy');
        });
        Route::prefix('informasi')->group(function () {
            Route::get('/', [InformationController::class, 'index'])->name('admin.information.index');
            Route::get('/show/{encrypted_id}', [InformationController::class, 'show'])->name('admin.information.show');
            Route::post('/store-information', [InformationController::class, 'storeInformation'])->name('admin.information.store');
            Route::get('/{encrypted_id}/edit', [InformationController::class, 'editInformation'])->name('admin.information.edit');
            Route::put('/{encrypted_id}/update', [InformationController::class, 'updateInformation'])->name('admin.information.update');
            Route::delete('/{encrypted_id}', [InformationController::class, 'deleteInformation'])->name('admin.information.destroy');
            Route::post('/gallery', [InformationController::class, 'storeGallery'])->name('admin.information.gallery.store');
            Route::delete('/gallery/{encrypted_id}', [InformationController::class, 'deleteGallery'])->name('admin.information.gallery.destroy');
            Route::post('category/store', [InformationCategoryController::class, 'storeCategory'])->name('admin.information.category.store');
            Route::put('information-category/{encrypted_id}/update', [InformationCategoryController::class, 'updateCategory'])->name('admin.information.category.update');
            Route::delete('information-category/{encrypted_id}/destroy', [InformationCategoryController::class, 'destroyCategory'])->name('admin.information.category.destroy');
        });
        Route::prefix('alumni-berprestasi')->group(function () {
            Route::get('/', [OutstandingAlumniController::class, 'index'])->name('admin.outstanding-alumni.index');
            Route::post('/store', [OutstandingAlumniController::class, 'store'])->name('admin.outstanding-alumni.store');
            Route::get('/{encrypted_id}/edit', [OutstandingAlumniController::class, 'edit'])->name('admin.outstanding-alumni.edit');
            Route::put('/{encrypted_id}', [OutstandingAlumniController::class, 'update'])->name('admin.outstanding-alumni.update');
            Route::delete('/{encrypted_id}', [OutstandingAlumniController::class, 'destroy'])->name('admin.outstanding-alumni.destroy');
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
    Route::get('/login', [AuthController::class, 'LoginView'])->name('login.view');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/forgot-password', [AuthController::class, 'alumniForgetPasswordView'])->name('alumni.forgot-password-view');
    Route::post('/forgot-password', [AuthController::class, 'alumniForgetPassword'])->name('alumni.forgot-password');
    Route::get('/verify-forgot-password-otp', [AuthController::class, 'alumniVerifyForgotPasswordOtpView'])->name('alumni.verify-forgot-password-otp-view');
    Route::post('/verify-forgot-password-otp', [AuthController::class, 'alumniVerifyForgotPasswordOtp'])->name('alumni.verify-forgot-password-otp');
    Route::get('/reset-password', [AuthController::class, 'alumniResetPasswordView'])->name('alumni.reset-password-view');
    Route::post('/reset-password', [AuthController::class, 'alumniResetPassword'])->name('alumni.reset-password');
    Route::post('/logout', [AuthController::class, 'logout'])->name('alumni.logout');
});

Route::middleware('alumni')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'profile'])->name('alumni.profile');
        Route::put('/', [ProfileController::class, 'updateProfile'])->name('alumni.profile.update');
        Route::post('/upload-photo', [ProfileController::class, 'uploadProfilePhoto'])->name('alumni.profile.upload-photo');
        Route::post('/educational-backgrounds', [ProfileController::class, 'storeEducationalBackground'])->name('alumni.educational-backgrounds.store');
        Route::get('/educational-backgrounds/{id}/edit', [ProfileController::class, 'editEducationalBackground'])->name('alumni.educational-backgrounds.edit');
        Route::put('/educational-backgrounds/{id}', [ProfileController::class, 'updateEducationalBackground'])->name('alumni.educational-backgrounds.update');
        Route::delete('/educational-backgrounds/{id}', [ProfileController::class, 'destroyEducationalBackground'])->name('alumni.educational-backgrounds.destroy');
        Route::post('/careers', [ProfileController::class, 'storeCareer'])->name('alumni.careers.store');
        Route::get('/careers/{id}/edit', [ProfileController::class, 'editCareer'])->name('alumni.careers.edit');
        Route::put('/careers/{id}', [ProfileController::class, 'updateCareer'])->name('alumni.careers.update');
        Route::delete('/careers/{id}', [ProfileController::class, 'destroyCareer'])->name('alumni.careers.destroy');
    });
    Route::get('/change-password', [ProfileController::class, 'changePasswordView'])->name('alumni.change-password-view');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('alumni.change-password');
});

// Information pages for guest/public
Route::get('/informasi', [GuestInformationController::class, 'index'])->name('information.index');
Route::get('/informasi/{id}', [GuestInformationController::class, 'show'])->name('information.show');

// Outstanding Alumni pages for guest/public
Route::get('/alumni-berprestasi', [GuestOutstandingAlumniController::class, 'index'])->name('outstanding-alumni.index');
Route::get('/alumni-berprestasi/{id}', [GuestOutstandingAlumniController::class, 'show'])->name('outstanding-alumni.show');
