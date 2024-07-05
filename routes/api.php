<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DislikeController;
use App\Http\Controllers\LikeController;

// ROUTE Users
Route::resource('/user', UserController::class);

// ROUTE Videos
Route::resource('/videos', VideoController::class);

// ROUTE Email
Route::post('/send-email', [MailController::class, 'sendEmail']);

// ROUTES for Comments
Route::post('/videos/{video_id}/comments/{user_id}', [CommentController::class, 'store']);

// Ruta para dar like a un video
Route::post('/videos/{video_id}/likes/{user_id}', [LikeController::class, 'store']);

// Ruta para dar dislike a un video
Route::post('/videos/{video_id}/dislikes/{user_id}', [DislikeController::class, 'store']);
