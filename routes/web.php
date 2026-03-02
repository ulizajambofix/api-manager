<?php

use App\Http\Controllers\Web\DashboardPageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardPageController::class)->name('dashboard');
});
