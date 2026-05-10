```markdown
# Hospital System - UTS

Sistem informasi manajemen rumah sakit berbasis Microservices yang dijalankan sepenuhnya di dalam environment Docker.

## Tech Stack
- **Framework:** Laravel
- **Database:** MySQL
- **Message Broker:** RabbitMQ
- **Infrastructure:** Docker & Docker Compose

## Arsitektur & Daftar Port
Aplikasi ini terbagi menjadi beberapa layanan independen yang berjalan di port berikut:
- **Patient Service:** `http://localhost:8001`
- **Doctor Service:** `http://localhost:8002`
- **Appointment Service:** `http://localhost:8003`
- **Medical Record Service:** `http://localhost:8004`
- **RabbitMQ Management UI:** `http://localhost:15672`

---

## Cara Instalasi & Menjalankan Project

Pastikan **Docker Desktop** sudah terinstal dan berjalan di laptop sebelum memulai.

### 1. Clone Repository
```bash
git clone [https://github.com/neshaolivia/Hospital-System-UTS.git](https://github.com/neshaolivia/Hospital-System-UTS.git)
cd Hospital-System-UTS

```

### 2. Jalankan Infrastruktur Docker

Perintah ini akan secara otomatis mengunduh image, membangun container, dan menghubungkan semua service beserta database MySQL dan RabbitMQ di latar belakang.

```bash
docker-compose up -d --build

```

### 3. Migrasi Database

Karena setiap service memiliki database yang terisolasi, jalankan perintah migrasi ini satu per satu untuk membuat tabel di masing-masing layanan:

```bash
docker exec patient_service php artisan migrate
docker exec doctor_service php artisan migrate
docker exec appointment_service php artisan migrate
docker exec medical_record_service php artisan migrate

```

### 4. Menjalankan Queue Worker (RabbitMQ)

Khusus untuk service yang mengirim atau menerima pesan antrean (seperti Appointment Service), jalankan worker di terminal terpisah agar antrean diproses:

```bash
docker exec appointment_service php artisan queue:work

```

---

## Cara Mematikan Sistem

Untuk mematikan seluruh layanan tanpa menghapus data di database, gunakan perintah berikut di terminal utama:

```bash
docker-compose down

```

```

```
