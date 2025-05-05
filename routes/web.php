<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\JobsController;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isAdmin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('admin.updateProfile');
    Route::put('/update-password', [AccountController::class, 'updatePassword'])->name('admin.updatePassword');
});

// Account Routes
Route::group(['prefix' => 'account'], function () {

    // Guest Routes
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/register', [AccountController::class, 'registration'])->name('account.registration');
        Route::post('/process-register', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });

    // Authenticated Routes
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::put('/update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');
        Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.createJob'); // GET for the form
        Route::post('/save-job', [AccountController::class, 'saveJob'])->name('account.saveJob'); // POST for saving the job
        Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('account.myJobs'); // GET for viewing jobs
        Route::get('/my-jobs/edit/{jobId}', [AccountController::class, 'editJob'])->name('account.editJob'); // GET for viewing jobs
        Route::put('/update-job/{jobId}', [AccountController::class, 'updateJob'])->name('account.updateJob'); 
        Route::post('/delete-job/{jobId}', [AccountController::class, 'deleteJob'])->name('account.deleteJob'); 
    });

});
