<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])
    ->name('api.login');

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/user', [AuthController::class, 'me'])
        ->name('api.user');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('api.logout');

    Route::apiResource('tickets', TicketController::class);
});