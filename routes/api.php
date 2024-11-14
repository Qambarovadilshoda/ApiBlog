<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class,'register'])->name('register');
Route::post('/login', [AuthController::class,'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/logout', [AuthController::class,'logout']);
    Route::apiResource('/posts',PostController::class);
    Route::post('/comments/store', [CommentController::class,'store']);
    Route::delete('/comments/destroy/{comment}', [CommentController::class,'destroy']);
});
