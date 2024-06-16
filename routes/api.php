<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\EmojiController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\API\ListFriendController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\API\RequestFriendController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum')->name('me');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/confirm-code', [AuthController::class, 'comfirmCode']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('auth:sanctum')->name('reset.password');




// Post

Route::middleware('auth:sanctum')->group(function () {


    //emoji
    Route::prefix('/emoji')->group(function () {
        Route::get('/list', [EmojiController::class, 'index'])->name('emoji.list');
        Route::post('/create', [EmojiController::class, 'store'])->name('emoji.create');
        Route::delete('/delete/{id}', [EmojiController::class, 'destroy'])->name('emoji.delete');
    });

    //profile
    Route::prefix('/profile')->group(function () {
        Route::post('/create', [ProfileController::class, 'store'])->name('profile.create')->name('profile.create');
        Route::get('/show', [ProfileController::class, 'show'])->name('profile.show')->name('profile.create');
        Route::put('/update/{id}', [ProfileController::class, 'update'])->name('profile.update')->name('profile.create');
    });


    Route::prefix('/post')->group(function () {
        Route::get('/list', [PostController::class, 'index'])->name('post.list')->name('post.list');
        Route::post('/create', [PostController::class, 'store'])->name('post.create')->name('post.create');
        Route::get('/show/{id}', [PostController::class, 'show'])->name('post.show')->name('post.show');
        Route::put('/update/{id}', [PostController::class, 'update'])->name('post.update')->name('post.update');
        Route::delete('/delete/{id}', [PostController::class, 'destroy'])->name('post.destroy')->name('post.delete');
    });

    Route::prefix('/like')->group(function () {
        //likes
        Route::get('/list', [LikeController::class, 'index'])->name('like.list');
        Route::post('/create', [LikeController::class, 'store'])->name('like.create');
        Route::delete('/delete/{id}', [LikeController::class, 'destroy'])->name('like.delete');
    });

    Route::prefix('/comment')->group(function () {
        //likes
        Route::get('/list', [CommentController::class, 'index'])->name('comment.list');
        Route::post('/create', [CommentController::class, 'store'])->name('comment.create');
        Route::delete('/delete/{id}', [CommentController::class, 'destroy'])->name('comment.delete');
    });

    Route::prefix('/friend_request')->group(function () {
        //add friends
        Route::post('/send', [RequestFriendController::class, 'sendRequest'])->name('friend_request.send');
        Route::get('/list', [RequestFriendController::class, 'listFriendsRequest'])->name('friend_request.create');
        Route::post('/accept_friend/{id}', [RequestFriendController::class, 'acceptFriend'])->name('accept_friend.create');
        Route::post('/reject_friend/{id}', [RequestFriendController::class, 'rejectFriend'])->name('reject_friend.create');
    });

    Route::prefix('/friend')->group(function () {
        //add friends
        Route::get('/list', [ListFriendController::class, 'index'])->name('friend.list');
        Route::delete('/delete/{id}', [ListFriendController::class, 'destroy'])->name('friend.delete');
    });
});


