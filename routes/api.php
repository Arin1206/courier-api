<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourierController;


Route::prefix('couriers')
    ->controller(CourierController::class)
    ->group(function () {

        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{courier}', 'show');
        Route::put('/{courier}', 'update');
        Route::delete('/{courier}', 'destroy');

    });
