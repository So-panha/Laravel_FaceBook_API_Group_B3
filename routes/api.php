<?php

use App\Http\Controllers\Api\EmojiController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\ShareController;
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

//share

Route::get('/share/list',[ShareController::class,'index']);
Route::post('/share/create',[ShareController::class,'store']);
Route::put('/share/update/{id}',[ShareController::class,'update']);
Route::delete('/share/delete/{id}',[ShareController::class,'destroy']);