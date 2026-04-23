# Hospital Management System — Service-to-Service Communication
## UTS Enterprise Application Integration — Telkom University

---

## Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────┐
│                    HOSPITAL SERVICES                        │
│                                                             │
│  ┌──────────────┐      ┌──────────────┐                    │
│  │PatientService│      │DoctorService │                    │
│  │  Port: 8001  │      │  Port: 8002  │                    │
│  │   PROVIDER   │      │   PROVIDER   │                    │
│  └──────┬───────┘      └──────┬───────┘                    │
│         │  HTTP GET           │  HTTP GET                  │
│         └──────────┬──────────┘                            │
│                    ▼                                        │
│         ┌──────────────────────┐                           │
│         │  AppointmentService  │                           │
│         │     Port: 8003       │                           │
│         │ CONSUMER + PROVIDER  │                           │
│         └──────────┬───────────┘                           │
│                    │  HTTP GET                             │
│                    ▼                                        │
│         ┌──────────────────────┐                           │
│         │ MedicalRecordService │                           │
│         │     Port: 8004       │                           │
│         │ CONSUMER + PROVIDER  │                           │
│         └──────────────────────┘                           │
└─────────────────────────────────────────────────────────────┘
```

## Peran Provider & Consumer

| Service | Peran Provider | Peran Consumer |
|---------|---------------|----------------|
| PatientService | Menyediakan data pasien | - |
| DoctorService | Menyediakan data dokter | - |
| AppointmentService | Menyediakan data janji temu | Mengambil data dari PatientService & DoctorService |
| MedicalRecordService | Menyediakan data rekam medis | Mengambil data dari PatientService & AppointmentService |

---

## Cara Menjalankan Semua Service

### Langkah 1 — Buat 4 project Laravel baru

Jalankan masing-masing di terminal berbeda:

```bash
# Terminal 1 — Patient Service
composer create-project laravel/laravel patient-service
cd patient-service
php artisan install:api

# Terminal 2 — Doctor Service
composer create-project laravel/laravel doctor-service
cd doctor-service
php artisan install:api

# Terminal 3 — Appointment Service
composer create-project laravel/laravel appointment-service
cd appointment-service
php artisan install:api

# Terminal 4 — Medical Record Service
composer create-project laravel/laravel medical-record-service
cd medical-record-service
php artisan install:api
```

### Langkah 2 — Copy file ke masing-masing project

Copy file dari folder ini ke project Laravel yang sesuai:

```
patient-service/
  ├── app/Http/Controllers/PatientController.php
  ├── app/Http/Resources/PatientResource.php
  ├── app/Models/Patient.php
  ├── database/migrations/..._create_patients_table.php
  ├── database/seeders/PatientSeeder.php
  ├── database/seeders/DatabaseSeeder.php
  └── routes/api.php

doctor-service/
  ├── app/Http/Controllers/DoctorController.php
  ├── app/Http/Resources/DoctorResource.php
  ├── app/Models/Doctor.php
  ├── database/migrations/..._create_doctors_table.php
  ├── database/seeders/DoctorSeeder.php
  ├── database/seeders/DatabaseSeeder.php
  └── routes/api.php

appointment-service/
  ├── app/Http/Controllers/AppointmentController.php
  ├── app/Http/Resources/AppointmentResource.php
  ├── app/Models/Appointment.php
  ├── database/migrations/..._create_appointments_table.php
  ├── database/seeders/AppointmentSeeder.php
  ├── database/seeders/DatabaseSeeder.php
  └── routes/api.php

medical-record-service/
  ├── app/Http/Controllers/MedicalRecordController.php
  ├── app/Http/Resources/MedicalRecordResource.php
  ├── app/Models/MedicalRecord.php
  ├── database/migrations/..._create_medical_records_table.php
  ├── database/seeders/MedicalRecordSeeder.php
  ├── database/seeders/DatabaseSeeder.php
  └── routes/api.php
```

### Langkah 3 — Buat database di MySQL

```sql
CREATE DATABASE patient_service;
CREATE DATABASE doctor_service;
CREATE DATABASE appointment_service;
CREATE DATABASE medical_record_service;
```

### Langkah 4 — Setting .env masing-masing service

**patient-service/.env**
```
APP_NAME="Patient Service"
APP_URL=http://localhost:8001
DB_DATABASE=patient_service
DB_USERNAME=root
DB_PASSWORD=
APPOINTMENT_SERVICE_URL=http://localhost:8003
```

**doctor-service/.env**
```
APP_NAME="Doctor Service"
APP_URL=http://localhost:8002
DB_DATABASE=doctor_service
DB_USERNAME=root
DB_PASSWORD=
APPOINTMENT_SERVICE_URL=http://localhost:8003
```

**appointment-service/.env**
```
APP_NAME="Appointment Service"
APP_URL=http://localhost:8003
DB_DATABASE=appointment_service
DB_USERNAME=root
DB_PASSWORD=
PATIENT_SERVICE_URL=http://localhost:8001
DOCTOR_SERVICE_URL=http://localhost:8002
```

**medical-record-service/.env**
```
APP_NAME="Medical Record Service"
APP_URL=http://localhost:8004
DB_DATABASE=medical_record_service
DB_USERNAME=root
DB_PASSWORD=
PATIENT_SERVICE_URL=http://localhost:8001
APPOINTMENT_SERVICE_URL=http://localhost:8003
```

### Langkah 5 — Migrate & Seed

Jalankan di masing-masing folder service:

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### Langkah 6 — Jalankan semua service (4 terminal berbeda)

```bash
# Terminal 1
cd patient-service && php artisan serve --port=8001

# Terminal 2
cd doctor-service && php artisan serve --port=8002

# Terminal 3
cd appointment-service && php artisan serve --port=8003

# Terminal 4
cd medical-record-service && php artisan serve --port=8004
```

---

## Daftar Endpoint

### PatientService (port 8001)
| Method | URL | Deskripsi |
|--------|-----|-----------|
| GET | `/api/patients` | List semua pasien |
| GET | `/api/patients/{id}` | Detail pasien by ID |
| POST | `/api/patients` | Tambah pasien baru |
| PUT | `/api/patients/{id}` | Edit pasien |
| DELETE | `/api/patients/{id}` | Hapus pasien |

### DoctorService (port 8002)
| Method | URL | Deskripsi |
|--------|-----|-----------|
| GET | `/api/doctors` | List semua dokter |
| GET | `/api/doctors/{id}` | Detail dokter by ID |
| POST | `/api/doctors` | Tambah dokter baru |
| PUT | `/api/doctors/{id}` | Edit dokter |
| DELETE | `/api/doctors/{id}` | Hapus dokter |

### AppointmentService (port 8003)
| Method | URL | Deskripsi |
|--------|-----|-----------|
| GET | `/api/appointments` | List semua janji temu (include data pasien & dokter) |
| GET | `/api/appointments/{id}` | Detail janji temu by ID |
| POST | `/api/appointments` | Buat janji temu (validasi ke PatientService & DoctorService) |
| PUT | `/api/appointments/{id}` | Edit janji temu |
| DELETE | `/api/appointments/{id}` | Hapus janji temu |

### MedicalRecordService (port 8004)
| Method | URL | Deskripsi |
|--------|-----|-----------|
| GET | `/api/medical-records` | List semua rekam medis (include data pasien & appointment) |
| GET | `/api/medical-records/{id}` | Detail rekam medis by ID |
| POST | `/api/medical-records` | Buat rekam medis (validasi ke PatientService & AppointmentService) |
| PUT | `/api/medical-records/{id}` | Edit rekam medis |
| DELETE | `/api/medical-records/{id}` | Hapus rekam medis |

---

## Contoh Response

### POST /api/appointments (AppointmentService sebagai Consumer)

Request Body:
```json
{
    "patient_id": 1,
    "doctor_id": 1,
    "appointment_date": "2025-04-25",
    "appointment_time": "09:00",
    "complaint": "Demam tinggi dan batuk selama 3 hari"
}
```

Response (AppointmentService mengambil data dari PatientService & DoctorService):
```json
{
    "status": "Success",
    "message": "Appointment created successfully",
    "data": {
        "id": 1,
        "patient_id": 1,
        "doctor_id": 1,
        "appointment_date": "2025-04-25",
        "appointment_time": "09:00:00",
        "status": "Terjadwal",
        "complaint": "Demam tinggi dan batuk selama 3 hari",
        "patient": {
            "id": 1,
            "name": "Budi Santoso",
            "nik": "3578011234560001",
            "gender": "Laki-laki",
            "phone": "081234567890"
        },
        "doctor": {
            "id": 1,
            "name": "Dr. Andi Wijaya, Sp.PD",
            "specialization": "Penyakit Dalam",
            "status": "Aktif"
        }
    }
}
```

---

## Kriteria Penilaian yang Terpenuhi

- ✅ Implementasi komunikasi antar service (30%) — AppointmentService & MedicalRecordService melakukan HTTP request ke service lain
- ✅ Peran provider dan consumer per layanan (25%) — semua service memiliki peran masing-masing
- ✅ Dokumentasi dan penjelasan API (20%) — dokumentasi Postman per service
- ✅ Demo atau hasil komunikasi (25%) — bisa didemonstrasikan via Postman

---

## Anggota Kelompok

| Nama | NIM | Service |
|------|-----|---------|
| [Nama 1] | [NIM] | PatientService |
| [Nama 2] | [NIM] | DoctorService |
| [Nama 3] | [NIM] | AppointmentService |
| [Nama 4] | [NIM] | MedicalRecordService |
