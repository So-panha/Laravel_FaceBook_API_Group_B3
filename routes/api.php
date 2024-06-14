<?php

use App\Http\Controllers\Api\EmojiController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');


//emoji
Route::get('/emoji/list',[EmojiController::class,'index'])->name('emoji.list');
Route::post('/emoji/create',[EmojiController::class, 'store'])  ;
Route::delete('/emoji/delete/{id}',[EmojiController::class, 'destroy']);

//likes

Route::get('/like/list',[LikeController::class,'index']);
Route::post('/like/create',[LikeController::class,'store']);
Route::delete('/like/delete/{id}',[LikeController::class,'destroy']);


//profile
Route::post('/profile/create',[ProfileController::class,'store']);
Route::get('/profile/show/{id}',[ProfileController::class,'show']);
Route::put('/profile/update/{id}',[ProfileController::class,'update']);
Route::get('/post/list',[PostController::class,'index'])->name('post.list');
Route::post('/post/create',[PostController::class,'store'])->name('post.create');
Route::get('/post/show/{id}',[PostController::class,'show'])->name('post.show');
Route::put('/post/update/{id}',[PostController::class,'update'])->name('post.update');
Route::delete('/post/delete/{id}',[PostController::class,'destroy'])->name('post.destroy');

