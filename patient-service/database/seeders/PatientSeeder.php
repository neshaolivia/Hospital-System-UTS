<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            [
                'name'       => 'Budi Santoso',
                'nik'        => '3578011234560001',
                'gender'     => 'Laki-laki',
                'birth_date' => '1990-05-15',
                'phone'      => '081234567890',
                'address'    => 'Jl. Pahlawan No. 10, Surabaya',
                'blood_type' => 'A',
            ],
            [
                'name'       => 'Siti Rahayu',
                'nik'        => '3578019876540002',
                'gender'     => 'Perempuan',
                'birth_date' => '1985-08-20',
                'phone'      => '082345678901',
                'address'    => 'Jl. Melati No. 5, Surabaya',
                'blood_type' => 'B',
            ],
            [
                'name'       => 'Ahmad Fauzi',
                'nik'        => '3578015432100003',
                'gender'     => 'Laki-laki',
                'birth_date' => '1995-12-01',
                'phone'      => '083456789012',
                'address'    => 'Jl. Kenanga No. 3, Surabaya',
                'blood_type' => 'O',
            ],
            [
                'name'       => 'Carolyn Langosh',
                'nik'        => '3578011234560005',
                'gender'     => 'Perempuan',
                'birth_date' => '1990-07-16',
                'phone'      => '081236351321',
                'address'    => 'Jl. Mawar No. 45, Surabaya',
                'blood_type' => 'A',
            ],
            [
                'name'       => 'Ericka Wisoky',
                'nik'        => '35787832105461235',
                'gender'     => 'Perempuan',
                'birth_date' => '1989-12-25',
                'phone'      => '084658700240',
                'address'    => 'Jl. Melati No. 20, Surabaya',
                'blood_type' => 'B',
            ],
            [
                'name'       => 'Jeromy Baumbach',
                'nik'        => '7982315720066610',
                'gender'     => 'Laki-laki',
                'birth_date' => '1990-03-20',
                'phone'      => '083541069122',
                'address'    => 'Jl. Kamboja No. 50, Surabaya',
                'blood_type' => 'O',
            ],
            [
                'name'       => 'Laury Mohr',
                'nik'        => '7875247932002000',
                'gender'     => 'Perempuan',
                'birth_date' => '1990-07-30',
                'phone'      => '087921853131',
                'address'    => 'Jl. Pahlawan No. 10, Surabaya',
                'blood_type' => 'A',
            ],
            [
                'name'       => 'Jamar Langosh',
                'nik'        => '3578011234560001',
                'gender'     => 'Laki-laki',
                'birth_date' => '1990-05-15',
                'phone'      => '081234567890',
                'address'    => 'Jl. Pahlawan No. 10, Surabaya',
                'blood_type' => 'B',
            ],
        ];

        foreach ($patients as $data) {
            Patient::firstOrCreate(['nik' => $data['nik']], $data);
        }
    }
}
