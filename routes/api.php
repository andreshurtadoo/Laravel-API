<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\MailController;

// ROUTE Users
Route::resource('/user', UserController::class);

// ROUTE Videos
Route::resource('/video', VideoController::class);

// ROUTE Email
Route::post('/send-email', [MailController::class, 'sendEmail']);
