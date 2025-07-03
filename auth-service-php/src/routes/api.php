<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login'   , [AuthController::class, 'login']);
Route::get('/validate', [AuthController::class, 'validateToken']);

Route::middleware('auth:sanctum')->get('/validate', [AuthController::class, 'validateToken']);
