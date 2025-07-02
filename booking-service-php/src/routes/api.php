<?php

use App\Http\Controllers\CheckinController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ReservaController;

Route::apiResource('pessoas'  , PessoaController::class);
Route::apiResource('reservas' , ReservaController::class);
Route::apiResource('checkins' , CheckinController::class);
Route::apiResource('checkouts', CheckoutController::class);