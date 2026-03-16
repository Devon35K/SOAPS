<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', ['canRegister' => true]);
})->name('home');

Route::get('/login', function () {
    return Inertia::render('auth/Login', [
        'canResetPassword' => true,
        'canRegister' => true,
    ]);
})->name('login');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
