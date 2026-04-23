<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Http\Resources\MedicalRecordResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class MedicalRecordController extends Controller
{
    // Helper: ambil data pasien dari PatientService
    private function getPatient($patient_id)
    {
        try {
            $response = Http::get(env('PATIENT_SERVICE_URL') . '/api/patients/' . $patient_id);
            $data = $response->json();
            if ($data['status'] === 'Success') {
                return $data['data'];
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    // Helper: ambil data appointment dari AppointmentService
    private function getAppointment($appointment_id)
    {
        try {
            $response = Http::get(env('APPOINTMENT_SERVICE_URL') . '/api/appointments/' . $appointment_id);
            $data = $response->json();
            if ($data['status'] === 'Success') {
                return $data['data'];
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    // GET /api/medical-records
    public function index()
    {
        $records = MedicalRecord::all();

        $result = $records->map(function ($record) {
            $data                = $record->toArray();
            $data['patient']     = $this->getPatient($record->patient_id);
            $data['appointment'] = $this->getAppointment($record->appointment_id);
            return $data;
        });

        return new MedicalRecordResource($result, 'Success', 'List of medical records');
    }

    // GET /api/medical-records/{id}
    public function show($id)
    {
        $record = MedicalRecord::find($id);
        if (!$record) {
            return new MedicalRecordResource(null, 'Failed', 'Medical record not found');
        }

        $data                = $record->toArray();
        $data['patient']     = $this->getPatient($record->patient_id);
        $data['appointment'] = $this->getAppointment($record->appointment_id);

        return new MedicalRecordResource($data, 'Success', 'Medical record found');
    }

    // POST /api/medical-records
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id'     => 'required|integer',
            'appointment_id' => 'required|integer',
            'diagnosis'      => 'required|string',
            'treatment'      => 'required|string',
            'prescription'   => 'nullable|string',
            'record_date'    => 'required|date',
        ]);

        if ($validator->fails()) {
            return new MedicalRecordResource(null, 'Failed', $validator->errors());
        }

        // Validasi ke PatientService
        $patient = $this->getPatient($request->patient_id);
        if (!$patient) {
            return new MedicalRecordResource(null, 'Failed', 'Patient not found in Patient Service');
        }

        // Validasi ke AppointmentService
        $appointment = $this->getAppointment($request->appointment_id);
        if (!$appointment) {
            return new MedicalRecordResource(null, 'Failed', 'Appointment not found in Appointment Service');
        }

        $record = MedicalRecord::create($request->all());

        $data                = $record->toArray();
        $data['patient']     = $patient;
        $data['appointment'] = $appointment;

        return new MedicalRecordResource($data, 'Success', 'Medical record created successfully');
    }

    // PUT /api/medical-records/{id}
    public function update(Request $request, $id)
    {
        $record = MedicalRecord::find($id);
        if (!$record) {
            return new MedicalRecordResource(null, 'Failed', 'Medical record not found');
        }

        $validator = Validator::make($request->all(), [
            'patient_id'     => 'sometimes|integer',
            'appointment_id' => 'sometimes|integer',
            'diagnosis'      => 'sometimes|string',
            'treatment'      => 'sometimes|string',
            'prescription'   => 'nullable|string',
            'record_date'    => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return new MedicalRecordResource(null, 'Failed', $validator->errors());
        }

        $record->update($request->all());
        $record = $record->fresh();

        $data                = $record->toArray();
        $data['patient']     = $this->getPatient($record->patient_id);
        $data['appointment'] = $this->getAppointment($record->appointment_id);

        return new MedicalRecordResource($data, 'Success', 'Medical record updated successfully');
    }

    // DELETE /api/medical-records/{id}
    public function destroy($id)
    {
        $record = MedicalRecord::find($id);
        if (!$record) {
            return new MedicalRecordResource(null, 'Failed', 'Medical record not found');
        }

        $data                = $record->toArray();
        $data['patient']     = $this->getPatient($record->patient_id);
        $data['appointment'] = $this->getAppointment($record->appointment_id);

        $record->delete();
        return new MedicalRecordResource($data, 'Success', 'Medical record deleted successfully');
    }
}
