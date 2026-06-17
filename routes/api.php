<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourierController;

Route::group(['prefix' => 'couriers'], function () {
    Route::get('/', [CourierController::class, 'index']);
    Route::post('/', [CourierController::class, 'store']);
    Route::get('/{courier}', [CourierController::class, 'show']);
    Route::put('/{courier}', [CourierController::class, 'update']);
    Route::delete('/{courier}', [CourierController::class, 'destroy']);
});