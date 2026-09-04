<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::apiResource('category', CategoryController::class);
Route::apiResource('category', LessonController::class);
Route::apiResource('category', PaymentController::class);
Route::apiResource('category', UserController::class);
Route::apiResource('category', VehicleController::class);
Route::apiResource('category', LessonController::class);
Route::apiResource('category', LessonController::class);