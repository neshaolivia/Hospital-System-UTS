<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function show($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail appointment',
            'data' => new AppointmentResource($appointment)
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required'
        ]);

        $patientCheck = Http::get('http://localhost:8001/api/patients/' . $request->patient_id);
        $doctorCheck = Http::get('http://localhost:8002/api/doctors/' . $request->doctor_id);

        if (!$patientCheck->successful() || empty($patientCheck->json()['data'])) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Patient tidak ditemukan'
            ], 400);
        }

        if (!$doctorCheck->successful() || empty($doctorCheck->json()['data'])) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Doctor tidak ditemukan'
            ], 400);
        }

        $appointment->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil update appointment',
            'data' => new AppointmentResource($appointment)
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required'
        ]);

        $patientCheck = Http::get('http://localhost:8001/api/patients/' . $request->patient_id);

        if (!$patientCheck->successful() || empty($patientCheck->json()['data'])) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Patient tidak ditemukan'
            ], 400);
        }

        $doctorCheck = Http::get('http://localhost:8002/api/doctors/' . $request->doctor_id);

        if (!$doctorCheck->successful() || empty($doctorCheck->json()['data'])) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Doctor tidak ditemukan'
            ], 400);
        }

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil tambah appointment',
            'data' => new AppointmentResource($appointment)
        ], 201);
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $appointment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus appointment'
        ], 200);
    }
}
