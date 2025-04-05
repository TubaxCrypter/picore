<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/content-management', [App\Http\Controllers\ContentController::class, 'index'])->name('content.management');
    Route::post('/content', [App\Http\Controllers\ContentController::class, 'store'])->name('content.store');
    Route::put('/content/{content}', [App\Http\Controllers\ContentController::class, 'update'])->name('content.update');
    Route::delete('/content/{content}', [App\Http\Controllers\ContentController::class, 'destroy'])->name('content.destroy');

    // Blog rotaları
    Route::get('/blogs', [App\Http\Controllers\BlogController::class, 'index'])->name('blogs.index');
    Route::post('/blogs', [App\Http\Controllers\BlogController::class, 'store'])->name('blogs.store');
    Route::put('/blogs/{blog}', [App\Http\Controllers\BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [App\Http\Controllers\BlogController::class, 'destroy'])->name('blogs.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
