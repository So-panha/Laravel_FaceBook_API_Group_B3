<?php

use App\Http\Controllers\Api\AvatarController;
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

//likes

Route::get('/like/list', [LikeController::class, 'index']);
Route::post('/like/create', [LikeController::class, 'store']);
Route::delete('/like/delete/{id}', [LikeController::class, 'destroy']);


//profile
Route::post('/profile/create',[ProfileController::class,'store']);
Route::get('/profile/show/{id}',[ProfileController::class,'show']);
Route::put('/profile/update/{id}',[ProfileController::class,'update']);
// Route::put('/profile/edit/{id}',[ProfileController::class,'edit']);




//avatar

Route::post('/avatar/create',[AvatarController::class,'store']);

