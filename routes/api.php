<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::apiResource('posts', PostController::class);
    Route::post('posts/{post}/update', [PostController::class, 'update']);
    Route::apiResource('comments', CommentController::class);
    Route::post('comments/{comment}/update', [CommentController::class, 'update']);
});
