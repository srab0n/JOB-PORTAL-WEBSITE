<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminController;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isAdmin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('admin.updateProfile');
    Route::put('/update-password', [AccountController::class, 'updatePassword'])->name('admin.updatePassword');
});

// Account Routes
Route::group(['account'], function () {

    // Guest Route (for unauthenticated users)
    Route::group(['middleware' => 'guest'], function() {
        Route::get('/account/register', [AccountController::class, 'registration'])->name('account.registration');
        Route::post('/account/process-register', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
        Route::get('/account/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/account/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });

    // Authenticated Routes (for logged-in users)
    Route::group(['middleware' => 'auth'], function() {
        Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::put('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::put('/account/update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword'); // Added route for updating password
    });

});
