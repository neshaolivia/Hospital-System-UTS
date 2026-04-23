<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            [
                'patient_id'     => 1,
                'appointment_id' => 3,
                'diagnosis'      => 'Flu dan infeksi saluran pernapasan atas',
                'treatment'      => 'Istirahat, minum air putih yang cukup, kompres hangat',
                'prescription'   => 'Paracetamol 500mg 3x1, Ambroxol 30mg 3x1, Vitamin C 500mg 1x1',
                'record_date'    => '2025-04-26',
            ],
            [
                'patient_id'     => 3,
                'appointment_id' => 3,
                'diagnosis'      => 'Migrain kronik',
                'treatment'      => 'Hindari pemicu stres, istirahat cukup di ruangan gelap',
                'prescription'   => 'Ibuprofen 400mg 2x1, Sumatriptan 50mg jika perlu',
                'record_date'    => '2025-04-26',
            ],
        ];

        foreach ($records as $data) {
            MedicalRecord::create($data);
        }
    }
}
