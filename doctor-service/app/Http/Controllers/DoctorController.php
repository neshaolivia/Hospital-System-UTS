<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Http\Resources\DoctorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    // GET /api/doctors
    public function index()
    {
        $doctors = Doctor::all();
        return new DoctorResource($doctors, 'Success', 'List of doctors');
    }

    // GET /api/doctors/{id}
    public function show($id)
    {
        $doctor = Doctor::find($id);
        if ($doctor) {
            return new DoctorResource($doctor, 'Success', 'Doctor found');
        }
        return new DoctorResource(null, 'Failed', 'Doctor not found');
    }

    // POST /api/doctors
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'           => 'required|string',
            'specialization' => 'required|string',
            'license_number' => 'required|string|unique:doctors,license_number',
            'phone'          => 'required|string',
            'email'          => 'required|email|unique:doctors,email',
            'status'         => 'sometimes|in:Aktif,Tidak Aktif',
        ]);

        if ($validator->fails()) {
            return new DoctorResource(null, 'Failed', $validator->errors());
        }

        $doctor = Doctor::create($request->all());
        return new DoctorResource($doctor, 'Success', 'Doctor created successfully');
    }

    // PUT /api/doctors/{id}
    public function update(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return new DoctorResource(null, 'Failed', 'Doctor not found');
        }

        $validator = Validator::make($request->all(), [
            'name'           => 'sometimes|string',
            'specialization' => 'sometimes|string',
            'license_number' => 'sometimes|string|unique:doctors,license_number,' . $id,
            'phone'          => 'sometimes|string',
            'email'          => 'sometimes|email|unique:doctors,email,' . $id,
            'status'         => 'sometimes|in:Aktif,Tidak Aktif',
        ]);

        if ($validator->fails()) {
            return new DoctorResource(null, 'Failed', $validator->errors());
        }

        $doctor->update($request->all());
        return new DoctorResource($doctor->fresh(), 'Success', 'Doctor updated successfully');
    }

    // DELETE /api/doctors/{id}
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return new DoctorResource(null, 'Failed', 'Doctor not found');
        }
        $deleted = $doctor->toArray();
        $doctor->delete();
        return new DoctorResource($deleted, 'Success', 'Doctor deleted successfully');
    }
}
