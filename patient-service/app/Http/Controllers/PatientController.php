<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Resources\PatientResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    // GET /api/patients
    public function index()
    {
        $patients = Patient::all();
        return new PatientResource($patients, 'Success', 'List of patients');
    }

    // GET /api/patients/{id}
    public function show($id)
    {
        $patient = Patient::find($id);
        if ($patient) {
            return new PatientResource($patient, 'Success', 'Patient found');
        }
        return new PatientResource(null, 'Failed', 'Patient not found');
    }

    // POST /api/patients
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string',
            'nik'        => 'required|string|unique:patients,nik',
            'gender'     => 'required|in:Laki-laki,Perempuan',
            'birth_date' => 'required|date',
            'phone'      => 'required|string',
            'address'    => 'required|string',
            'blood_type' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return new PatientResource(null, 'Failed', $validator->errors());
        }

        $patient = Patient::create($request->all());
        return new PatientResource($patient, 'Success', 'Patient created successfully');
    }

    // PUT /api/patients/{id}
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return new PatientResource(null, 'Failed', 'Patient not found');
        }

        $validator = Validator::make($request->all(), [
            'name'       => 'sometimes|string',
            'nik'        => 'sometimes|string|unique:patients,nik,' . $id,
            'gender'     => 'sometimes|in:Laki-laki,Perempuan',
            'birth_date' => 'sometimes|date',
            'phone'      => 'sometimes|string',
            'address'    => 'sometimes|string',
            'blood_type' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return new PatientResource(null, 'Failed', $validator->errors());
        }

        $patient->update($request->all());
        return new PatientResource($patient->fresh(), 'Success', 'Patient updated successfully');
    }

    // DELETE /api/patients/{id}
    public function destroy($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return new PatientResource(null, 'Failed', 'Patient not found');
        }
        $deleted = $patient->toArray();
        $patient->delete();
        return new PatientResource($deleted, 'Success', 'Patient deleted successfully');
    }
}
