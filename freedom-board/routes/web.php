<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// redirect the root to main page (board)
Route::get('/', function () {
    return redirect()->route('posts.index');
});

// route to main board
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

//
Route::middleware('auth')->group(function (){
    // submitting a new post or reply
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // deleting a post
    Route::post('/posts/{post}', [PostController::class, 'remove'])->name('posts.remove');
});
