<?php

use Illuminate\Support\Facades\Route;

// redirect the root to main page (board)
Route::get('/', function () {
    return redirect()-route('posts.index');
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
