<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\EmployerController;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/search', [JobsController::class, 'search'])->name('jobs.search');
Route::get('/jobs/{job}', [JobsController::class, 'detail'])->name('jobs.detail');


// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isAdmin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/manage_users', [AdminController::class, 'index'])->name('admin.manage_users');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('admin.updateProfile');
    Route::put('/update-password', [AccountController::class, 'updatePassword'])->name('admin.updatePassword');
    
    // New routes for user management
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');

    // Manage Jobs Routes
    Route::get('/manage-jobs', [AdminController::class, 'manageJobs'])->name('admin.manage_jobs');
    Route::delete('/jobs/{job}', [AdminController::class, 'deleteJob'])->name('admin.delete_job');

    // Manage Categories Routes
    Route::get('/manage-categories', [AdminController::class, 'manageCategories'])->name('admin.manage_categories');
    Route::post('/categories/store', [AdminController::class, 'storeCategory'])->name('admin.store_category');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('admin.delete_category');
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
        Route::delete('/delete-account', [AccountController::class, 'deleteAccount'])->name('account.deleteAccount');
        
        // Job-related routes with jobCreation middleware
        Route::group(['middleware' => 'jobCreation'], function () {
            Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.createJob');
            Route::post('/save-job', [AccountController::class, 'saveJob'])->name('account.saveJob');
            Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('account.myJobs');
            Route::get('/my-jobs/edit/{jobId}', [AccountController::class, 'editJob'])->name('account.editJob');
            Route::put('/update-job/{jobId}', [AccountController::class, 'updateJob'])->name('account.updateJob');
            Route::post('/delete-job/{jobId}', [AccountController::class, 'deleteJob'])->name('account.deleteJob');
        });
    });

});

// Employer Dashboard Routes
Route::middleware(['auth', 'employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');
    Route::post('/update-company-info', [EmployerController::class, 'updateCompanyInfo'])->name('updateCompanyInfo');
    
    // Job Management Routes
    Route::get('/jobs/create', [EmployerDashboardController::class, 'createJob'])->name('jobs.create');
    Route::post('/jobs', [EmployerDashboardController::class, 'storeJob'])->name('jobs.store');
    Route::get('/jobs/{job}/edit', [EmployerDashboardController::class, 'editJob'])->name('jobs.edit');
    Route::put('/jobs/{job}', [EmployerDashboardController::class, 'updateJob'])->name('jobs.update');
    Route::delete('/jobs/{job}', [EmployerDashboardController::class, 'deleteJob'])->name('jobs.delete');
    Route::get('/jobs/{job}/applicants', [EmployerDashboardController::class, 'viewApplicants'])->name('jobs.applicants');
});
