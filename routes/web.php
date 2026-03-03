<?php

use App\Http\Controllers\Web\DashboardPageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => Inertia::render('Auth/Login'))->name('login');
    Route::get('/register', fn () => Inertia::render('Auth/Register'))->name('register');
    Route::get('/forgot-password', fn () => Inertia::render('Auth/ForgotPassword'))->name('password.request');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardPageController::class)->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn () => Inertia::render('Auth/VerifyEmail'))->name('verification.notice');
});
