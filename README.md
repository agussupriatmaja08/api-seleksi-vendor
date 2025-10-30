# Project Test Backend Developer - Sadhana Corporation

Proyek ini membangun API sederhana untuk studi kasus PT. Maju Karya, yang bertujuan membantu proses seleksi vendor melalui sistem pelaporan.

## Tech Stack

-   Bahasa: PHP 8.4+
-   Framework: Laravel 12
-   Database: MySQL
-   Otentikasi: JWT (menggunakan tymon/jwt-auth)
-   Dokumentasi API: Scramble dan Postman

---

## 1. Instalasi dan Setup

Harap ikuti langkah-langkah ini untuk menjalankan proyek secara lokal.

### A. Persiapan Awal

Clone Repository

```bash
git clone https://github.com/agussupriatmaja08/api-seleksi-vendor.git
cd api-seleksi-vendor
```

Install Dependencies

```bash
composer install
```

Setup Environment

Salin file `.env.example` dan buat file `.env` baru.

```bash
cp .env.example .env
```

Buat kunci aplikasi Laravel.

```bash
php artisan key:generate
```

Buat kunci rahasia untuk JWT.

```bash
php artisan jwt:secret
```

### B. Setup Database

Buka file `.env` Anda dan sesuaikan koneksi database (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD) agar sesuai dengan pengaturan lokal Anda.

Contoh konfigurasi lokal (MySQL):

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api-seleksi-vendor
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan Script Migration

Perintah ini akan membuat semua tabel yang diperlukan (vendors, items, vendor_items, orders, users) sesuai dengan ERD dan menjalankan perintah seeder untuk memambahkan semua data dummy pada tabel termasuk user.

```bash
php artisan migrate --seed
```

### C. Jalankan Server

```bash
php artisan serve
```

Aplikasi sekarang berjalan di http://127.0.0.1:8000.

---

## 2. Akun Pengguna (User Login)

Berikut adalah kredensial pengguna yang dapat digunakan untuk mendapatkan Token JWT melalui endpoint `POST /api/login`:

-   Email: `admin@gmail.com`
-   Password: `12345678`

---

## 3. Dokumentasi dan Pengujian API

Seluruh dokumentasi API (termasuk endpoint CRUD dan 3 Laporan Utama) telah dibuat menggunakan Scramble dan Postman.

### A. Akses Dokumentasi

Anda dapat mengakses dokumentasi API interaktif (Scramble) di:

```
http://127.0.0.1:8000/docs/api
```

Atau anda juga dapat mengakses dokumentasi API lewat Postman :

```
https://documenter.getpostman.com/view/27895963/2sB3Wnwh8b#4b00c237-c45f-4102-9258-3f050e92a814
```

---

Jika Anda butuh bantuan tambahan beri tahu saya dan saya akan bantu.

Terima kasih.
