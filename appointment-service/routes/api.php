<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request;



Route::get('/appointments', [AppointmentController::class, 'index']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
