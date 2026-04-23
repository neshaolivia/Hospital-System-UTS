<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'name'           => 'Dr. Andi Wijaya, Sp.PD',
                'specialization' => 'Penyakit Dalam',
                'license_number' => 'STR-001-2024',
                'phone'          => '081111111111',
                'email'          => 'andi.wijaya@hospital.com',
                'status'         => 'Aktif',
            ],
            [
                'name'           => 'Dr. Rini Kusuma, Sp.JP',
                'specialization' => 'Jantung dan Pembuluh Darah',
                'license_number' => 'STR-002-2024',
                'phone'          => '082222222222',
                'email'          => 'rini.kusuma@hospital.com',
                'status'         => 'Aktif',
            ],
            [
                'name'           => 'Dr. Hendra Saputra, Sp.B',
                'specialization' => 'Bedah Umum',
                'license_number' => 'STR-003-2024',
                'phone'          => '083333333333',
                'email'          => 'hendra.saputra@hospital.com',
                'status'         => 'Aktif',
            ],
            [
                'name'           => 'Dr. Hendra Saputra, Sp.B',
                'specialization' => 'Bedah Umum',
                'license_number' => 'STR-003-2024',
                'phone'          => '083333333333',
                'email'          => 'hendra.saputra@hospital.com',
                'status'         => 'Aktif',
            ],
            [
                'name'           => 'Dr. Hendra Saputra, Sp.B',
                'specialization' => 'Bedah Umum',
                'license_number' => 'STR-003-2024',
                'phone'          => '083333333333',
                'email'          => 'hendra.saputra@hospital.com',
                'status'         => 'Aktif',
            ],
            [
                'name'           => 'Dr. Hendra Saputra, Sp.B',
                'specialization' => 'Bedah Umum',
                'license_number' => 'STR-003-2024',
                'phone'          => '083333333333',
                'email'          => 'hendra.saputra@hospital.com',
                'status'         => 'Aktif',
            ],
            [
                'name'           => 'Dr. Hendra Saputra, Sp.B',
                'specialization' => 'Bedah Umum',
                'license_number' => 'STR-003-2024',
                'phone'          => '083333333333',
                'email'          => 'hendra.saputra@hospital.com',
                'status'         => 'Aktif',
            ],
        ];

        foreach ($doctors as $data) {
            Doctor::firstOrCreate(['license_number' => $data['license_number']], $data);
        }
    }
}
