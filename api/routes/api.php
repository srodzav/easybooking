<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas públicas para servicios (catálogo público)
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{service}', [ServiceController::class, 'show']);

// Rutas públicas para reseñas (ver reseñas públicamente)
Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/{review}', [ReviewController::class, 'show']);

// Rutas protegidas con autenticación
Route::middleware('auth:sanctum')->group(function () {
    
    // Rutas de autenticación
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    
    // Rutas para administradores únicamente
    Route::middleware('admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::post('/services', [ServiceController::class, 'store']);
        Route::put('/services/{service}', [ServiceController::class, 'update']);
        Route::delete('/services/{service}', [ServiceController::class, 'destroy']);
    });
    
    // Rutas para clientes (crear/ver sus propias reservas y reseñas)
    Route::middleware('client')->group(function () {
        Route::get('/my-reservations', [ReservationController::class, 'index']);
        Route::post('/reservations', [ReservationController::class, 'store']);
        Route::get('/reservations/{reservation}', [ReservationController::class, 'show']);
        Route::put('/reservations/{reservation}', [ReservationController::class, 'update']);
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);
        
        Route::get('/my-reviews', [ReviewController::class, 'index']);
        Route::post('/reviews', [ReviewController::class, 'store']);
        Route::get('/reviews/{review}', [ReviewController::class, 'show']);
        Route::put('/reviews/{review}', [ReviewController::class, 'update']);
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
    });
    
    // Rutas para administradores - gestión completa de reservas y reseñas
    Route::middleware('admin')->group(function () {
        Route::get('/all-reservations', [ReservationController::class, 'index']);
        Route::get('/all-reviews', [ReviewController::class, 'index']);
        Route::get('/dashboard/stats', [UserController::class, 'dashboardStats']);
        Route::apiResource('reservations', ReservationController::class)->except(['index']);
        Route::apiResource('reviews', ReviewController::class)->except(['index', 'show']);
    });
});