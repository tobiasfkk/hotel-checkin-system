<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ReservaController;

Route::apiResource('pessoas', PessoaController::class);
Route::apiResource('reservas', ReservaController::class);