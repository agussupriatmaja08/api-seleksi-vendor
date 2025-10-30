# Project Test Backend Developer - Sadhana Corporation

Ini adalah submisi untuk Proyek Tes Backend Developer di Sadhana Corporation. Proyek ini membangun API sederhana untuk studi kasus PT. Maju Karya, yang bertujuan membantu proses seleksi vendor melalui sistem pelaporan.

## Tech Stack (Sesuai Rekomendasi)

-   Bahasa: PHP 8.1+
-   Framework: Laravel 10
-   Database: MySQL (atau PostgreSQL)
-   Otentikasi: JWT (menggunakan tymon/jwt-auth)
-   Dokumentasi API: Scramble

---

## 1. Instalasi dan Setup

Harap ikuti langkah-langkah ini untuk menjalankan proyek secara lokal.

### A. Persiapan Awal

Clone Repository

```bash
git clone [URL_GIT_ANDA]
cd [NAMA_FOLDER_PROYEK]
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
DB_DATABASE=sadhana_test
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan Script Migration

Perintah ini akan membuat semua tabel yang diperlukan (vendors, items, vendor_items, orders, users) sesuai dengan ERD yang disediakan.

```bash
php artisan migrate
```

Jalankan Database Seeder

Perintah ini akan mengisi database dengan data dummy (termasuk akun pengguna di bawah) agar API dapat langsung diuji.

```bash
php artisan db:seed
```

### C. Jalankan Server

```bash
php artisan serve
```

Aplikasi sekarang berjalan di http://127.0.0.1:8000.

---

## 2. Akun Pengguna (User Login)

Sesuai permintaan tes, berikut adalah kredensial pengguna yang dapat digunakan untuk mendapatkan Token JWT melalui endpoint `POST /api/login`:

-   Email: `admin@example.com`
-   Password: `password123`

---

## 3. Dokumentasi dan Pengujian API

Seluruh dokumentasi API (termasuk endpoint CRUD dan 3 Laporan Utama) telah dibuat menggunakan Scramble.

### A. Akses Dokumentasi

Anda dapat mengakses dokumentasi API interaktif di:

```
http://127.0.0.1:8000/docs/api
```

### B. Cara Menggunakan Dokumentasi (Penting)

1. Buka dokumentasi Scramble.
2. Di kanan atas, klik tombol "Authorize".
3. Salin `access_token` yang Anda dapatkan dari endpoint `POST /api/login` (menggunakan akun di atas).
4. Tempelkan token di modal otorisasi (pastikan diawali dengan `Bearer `).
5. Sekarang Anda dapat menguji semua endpoint yang dilindungi (`@authenticated`) langsung dari halaman dokumentasi.

---

## 4. Catatan Desain dan "Poin Plus"

Beberapa keputusan desain dan implementasi "poin plus" (sesuai permintaan tes) telah diterapkan:

-   **Validasi Input**: Seluruh input (Store dan Update) ditangani secara ketat menggunakan Form Request Classes (misal: `StoreVendorRequest`, `UpdateOrderRequest`).

-   **Arsitektur Service Layer**: Semua logika bisnis (CRUD dan Laporan) dipisahkan dari Controller dan ditempatkan di Service Layer (misal: `ItemService`, `ReportService`).

-   **Dependency Injection & Interface**: Controller di-inject dengan Interface (misal: `ItemInterface`) yang di-bind ke Service (misal: `ItemService`) di `AppServiceProvider` untuk loose coupling.

-   **Base ApiController**: Dibuat `ApiController` kustom yang berisi helper `sendResponse()` untuk menstandardisasi semua output JSON API, membuat controller lain tetap bersih dan ringkas.

---

Jika Anda butuh bantuan tambahan (menjalankan proyek, memodifikasi data dummy, atau menambahkan dokumentasi contoh), beri tahu saya dan saya akan bantu.

Terima kasih.
