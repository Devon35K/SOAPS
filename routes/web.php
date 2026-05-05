<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AdminController;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('intro');
})->name('home');

Route::get('/intro', function () {
    return view('intro');
})->name('intro');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Forgot Password routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// Email routes (Admin only)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/email/send-approval', [EmailController::class, 'sendApprovalEmail'])->name('email.approval');
    Route::post('/email/send-rejection', [EmailController::class, 'sendRejectionEmail'])->name('email.rejection');
    Route::post('/email/send-notification', [EmailController::class, 'sendNotificationEmail'])->name('email.notification');
});

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::middleware(['web', 'auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('student-athletes', [AdminController::class, 'studentAthletes'])->name('student-athletes');
    Route::get('achievements', [AdminController::class, 'achievements'])->name('achievements');
    Route::get('evaluations', [AdminController::class, 'evaluations'])->name('evaluations');
    Route::get('approved-docs', [AdminController::class, 'approvedDocs'])->name('approved-docs');
    Route::get('reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('account-approvals', [AdminController::class, 'accountApprovals'])->name('account-approvals');
    Route::post('approve-request', [AdminController::class, 'approveRequest'])->name('approve-request');
    Route::post('reject-request', [AdminController::class, 'rejectRequest'])->name('reject-request');
    Route::get('approval-document/{id}', [AdminController::class, 'viewApprovalDocument'])->name('approval-document');

    // Super Admin only routes
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('users', [AdminController::class, 'users'])->name('users');
        Route::get('users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    });
});

// User routes  
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\UserController::class, 'dashboard'])->name('dashboard');
    Route::get('submissions', [App\Http\Controllers\UserController::class, 'submissions'])->name('submissions');
    Route::get('achievements', [App\Http\Controllers\UserController::class, 'achievements'])->name('achievements');
    Route::get('track-records', [App\Http\Controllers\UserController::class, 'trackRecords'])->name('track-records');
    Route::get('profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
});

require __DIR__.'/settings.php';
