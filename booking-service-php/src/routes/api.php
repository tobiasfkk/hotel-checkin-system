<?php

use App\Http\Controllers\CheckinController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ReservaController;

Route::middleware(['jwt.auth'])->group(function () {

    // Rotas de consulta - Acessíveis por 'admin' e 'normal'
    Route::middleware(['role:admin,normal'])->group(function () {
        Route::get('pessoas', [PessoaController::class, 'index']);
        Route::get('pessoas/{pessoa}', [PessoaController::class, 'show']);

        Route::get('reservas', [ReservaController::class, 'index']);
        Route::get('reservas/{reserva}', [ReservaController::class, 'show']);

        Route::get('checkins', [CheckinController::class, 'index']);
        Route::get('checkins/{checkin}', [CheckinController::class, 'show']);

        Route::get('checkouts', [CheckoutController::class, 'index']);
        Route::get('checkouts/{checkout}', [CheckoutController::class, 'show']);
    });

    // Rotas de modificação - Acessíveis apenas por 'admin'
    Route::middleware(['role:admin'])->group(function () {
        Route::post('pessoas', [PessoaController::class, 'store']);
        Route::put('pessoas/{pessoa}', [PessoaController::class, 'update']);
        Route::delete('pessoas/{pessoa}', [PessoaController::class, 'destroy']);

        Route::post('reservas', [ReservaController::class, 'store']);
        Route::put('reservas/{reserva}', [ReservaController::class, 'update']);
        Route::delete('reservas/{reserva}', [ReservaController::class, 'destroy']);

        Route::post('checkins', [CheckinController::class, 'store']);
        Route::put('checkins/{checkin}', [CheckinController::class, 'update']);
        Route::delete('checkins/{checkin}', [CheckinController::class, 'destroy']);

        Route::post('checkouts', [CheckoutController::class, 'store']);
        Route::put('checkouts/{checkout}', [CheckoutController::class, 'update']);
        Route::delete('checkouts/{checkout}', [CheckoutController::class, 'destroy']);
    });
});