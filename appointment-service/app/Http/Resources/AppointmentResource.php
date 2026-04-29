<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $patientResponse = Http::get('http://localhost:8001/api/patients/' . $this->patient_id);
        $doctorResponse = Http::get('http://localhost:8002/api/doctors/' . $this->doctor_id);

        $patient = $patientResponse->successful() ? $patientResponse->json()['data'] : null;
        $doctor = $doctorResponse->successful() ? $doctorResponse->json()['data'] : null;

        return [
            'id' => $this->id,

            // hanya tampilkan ini (biar clean)
            'patient' => $patient,
            'doctor' => $doctor,
        ];
        // $patientService = env('PATIENT_SERVICE_URL');
        // $doctorService  = env('DOCTOR_SERVICE_URL');

        // $patient = Http::get("$patientService/api/patients/" . $this->patient_id)->json();
        // $doctor  = Http::get("$doctorService/api/doctors/" . $this->doctor_id)->json();

        // return [
        //     'id' => $this->id,
        //     'patient_id' => $this->patient_id,
        //     'doctor_id' => $this->doctor_id,
        //     'patient' => $patient['data'] ?? null,
        //     'doctor' => $doctor['data'] ?? null,
        // ];
    }
}
