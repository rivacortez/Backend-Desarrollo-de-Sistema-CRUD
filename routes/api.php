<?php


use App\ReservationManagement\Customers\Interfaces\Rest\CustomerController;
use Illuminate\Support\Facades\Route;

Route::apiResource('customers', CustomerController::class);
