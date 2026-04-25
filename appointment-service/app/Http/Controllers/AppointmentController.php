<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
// use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'List of appointments',
            'data' => AppointmentResource::collection(Appointment::all())
        ]);
    }
}
