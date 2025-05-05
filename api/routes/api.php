<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;

Route::apiResource('users', UserController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('reservations', ReservationController::class);
Route::apiResource('reviews', ReviewController::class);