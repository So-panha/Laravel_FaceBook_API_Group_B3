<?php

use App\Http\Controllers\Api\CommentController;
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
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');

Route::get('/post/list',[PostController::class,'index'])->name('post.list');
Route::post('/post/create',[PostController::class,'store'])->name('post.create');
Route::get('/post/show/{id}',[PostController::class,'show'])->name('post.show');
Route::put('/post/update/{id}',[PostController::class,'update'])->name('post.update');
Route::delete('/post/delete/{id}',[PostController::class,'destroy'])->name('post.destroy');

Route::get('/comment/list',[CommentController::class,'index'])->name('comment.list');
Route::post('/comment/create',[CommentController::class,'store'])->name('comment.create');
Route::get('/comment/show/{id}',[CommentController::class,'show'])->name('comment.show');
Route::put('/comment/update/{id}',[CommentController::class,'update'])->name('comment.update');
Route::delete('/comment/delete/{id}',[CommentController::class,'destroy'])->name('comment.destroy');