<?php


use App\ReservationManagement\Customers\Interfaces\Rest\CustomerController;
use App\ReservationManagement\Reservations\interfaces\rest\ReservationsController;
use App\ReservationManagement\Tables\interfaces\rest\TablesController;
use Illuminate\Support\Facades\Route;

Route::apiResource('customers', CustomerController::class);
Route::apiResource('tables', TablesController::class);
Route::apiResource('reservations', ReservationsController::class);
