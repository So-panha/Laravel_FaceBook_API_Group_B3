<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\Show_postController;
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

Route::get('/show_post/list',[Show_postController::class,'index'])->name('show_post.list');
Route::post('/show_post/create',[Show_postController::class,'store'])->name('show_post.create');
Route::get('/show_post/show/{id}',[Show_postController::class,'show'])->name('show_post.show');
Route::put('/show_post/update/{id}',[Show_postController::class,'update'])->name('show_post.update');
Route::delete('/show_post/delete/{id}',[Show_postController::class,'destroy'])->name('show_post.destroy');

Route::get('/friend/list',[FriendController::class,'index'])->name('friend.list');
Route::post('/friend/create',[FriendController::class,'store'])->name('friend.create');
Route::get('/friend/show/{id}',[FriendController::class,'show'])->name('friend.show');
Route::put('/friend/update/{id}',[FriendController::class,'update'])->name('friend.update');
Route::delete('/friend/delete/{id}',[FriendController::class,'destroy'])->name('friend.destroy');