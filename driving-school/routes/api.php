<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::apiResource('category', CategoryController::class);
Route::post('category/{category}', [CategoryController::class, 'update'])->name('category.update.multipart');
Route::apiResource('lessons', LessonController::class);
Route::apiResource('payments', PaymentController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('vehicles', VehicleController::class);