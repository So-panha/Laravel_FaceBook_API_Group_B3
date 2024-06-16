<?php

use App\Http\Controllers\Api\EmojiController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum')->name('me');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/confirm-code', [AuthController::class, 'comfirmCode']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('auth:sanctum')->name('reset.password');


//emoji
Route::get('/emoji/list', [EmojiController::class, 'index'])->name('emoji.list');
Route::post('/emoji/create', [EmojiController::class, 'store']);
Route::delete('/emoji/delete/{id}', [EmojiController::class, 'destroy']);

//profile
Route::post('/profile/create', [ProfileController::class, 'store']);
Route::get('/profile/show/{id}', [ProfileController::class, 'show']);
Route::put('/profile/update/{id}', [ProfileController::class, 'update']);


// Post

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/post')->group(function (){
        Route::get('/list', [PostController::class, 'index'])->name('post.list');
        Route::post('/create', [PostController::class, 'store'])->name('post.create');
        Route::get('/show/{id}', [PostController::class, 'show'])->name('post.show');
        Route::put('/update/{id}', [PostController::class, 'update'])->name('post.update');
        Route::delete('/delete/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    });

    Route::prefix('/like')->group(function (){
        //likes
        Route::get('/list', [LikeController::class, 'index']);
        Route::post('/create', [LikeController::class, 'store']);
        Route::delete('/delete/{id}', [LikeController::class, 'destroy']);
    });
});


