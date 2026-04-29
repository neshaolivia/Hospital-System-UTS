<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request;



Route::get('/appointments', [AppointmentController::class, 'index']);
Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
Route::apiResource('appointments', AppointmentController::class);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
