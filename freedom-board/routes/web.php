<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
// Authentication routes
Route::get('/login', [ProfileController::class, 'showLogin'])->name('login');
Route::post('/login', [ProfileController::class, 'login']);
Route::get('/register', [ProfileController::class, 'showRegister'])->name('register');
Route::post('/register', [ProfileController::class, 'register']);
Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

// Redirect root to the board
Route::get('/', function () {
    return redirect()->route('posts.index');
});

// Public board view
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Authenticated post actions
Route::middleware('auth')->group(function () {
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Breeze dashboard (keep for testing auth)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';