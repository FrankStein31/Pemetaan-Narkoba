# Pemetaan Narkoba — BNN Kabupaten Kediri

Platform pemetaan dan monitoring persebaran narkoba berbasis web untuk **BNN Kabupaten Kediri**. Aplikasi ini menyediakan visualisasi data interaktif berupa peta wilayah, manajemen data pasien, antrian, pengaduan masyarakat, serta fitur sosialisasi pencegahan narkoba.

---

## Fitur Utama

### Publik (Tanpa Login)
- **Peta Interaktif** (`/peta`) — Peta persebaran narkoba berbasis Google Maps yang dapat diakses oleh siapa saja tanpa perlu login

### Admin
| Modul | Deskripsi |
|---|---|
| **Dashboard** | Statistik & grafik persebaran narkoba per wilayah |
| **Peta Desa** (`/maps-desa`) | Peta kerawanan berdasarkan jumlah orang positif narkoba per desa |
| **Peta Sosialisasi** (`/maps-desa-sosialisasi`) | Peta status sosialisasi pencegahan narkoba per desa |
| **Peta Jenis Narkoba** (`/maps-desa-jenis-narkoba`) | Peta persebaran berdasarkan golongan narkoba (I, II, III) |
| **Data Pasien** | CRUD data pasien positif narkoba |
| **Data Warga** | Manajemen data warga per kecamatan & desa |
| **Antrian Pasien** | Sistem antrian pasien dengan nomor antrian otomatis |
| **Antrian Terlambat** | Penanganan pasien yang datang terlambat |
| **Pengaduan** | Kelola laporan & pengaduan dari masyarakat |
| **Sosialisasi** | Tracking kegiatan sosialisasi pencegahan narkoba |
| **Pesan** | Manajemen pesan / broadcast informasi |
| **Pengaturan** | Konfigurasi aplikasi, ganti password, verifikasi email |

### Masyarakat (User)
- Dashboard masyarakat
- Buat & kelola pengaduan

---

## Teknologi

| Komponen | Teknologi |
|---|---|
| **Framework** | Laravel 10.x |
| **PHP** | ≥ 8.2 |
| **Database** | MySQL |
| **Frontend** | Blade Templates, Bootstrap 5, jQuery |
| **Peta** | Google Maps JavaScript API v3 |
| **Grafik** | ApexCharts |
| **Search** | Select2 (real-time searchable dropdown) |
| **Build Tool** | Vite |
| **Autentikasi** | Laravel Sanctum |

---

## Instalasi

### Prasyarat
- PHP ≥ 8.2
- Composer
- MySQL / MariaDB
- Node.js & NPM (opsional, untuk Vite)
- Google Maps API Key

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd PemetaanNarkoba
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Edit file `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pemetaannarkoba
   DB_USERNAME=root
   DB_PASSWORD=

   GOOGLE_MAPS_API_KEY=your_google_maps_api_key_here
   ```

5. **Buat database & import data**
   ```bash
   # Buat database
   mysql -u root -e "CREATE DATABASE pemetaannarkoba;"

   # Import SQL dump (jika ada)
   mysql -u root pemetaannarkoba < pemetaannarkoba.sql

   # Atau jalankan migration & seeder
   php artisan migrate --seed
   ```

6. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```
   Aplikasi akan berjalan di `http://127.0.0.1:8000`

---

## Struktur Database

### Tabel Utama
| Tabel | Deskripsi |
|---|---|
| `users` | Data pengguna (admin & masyarakat) |
| `desa` | Data desa dengan koordinat, poligon, dan statistik |
| `kecamatan` | Data kecamatan |
| `patients` | Data pasien positif narkoba |
| `wargas` | Data warga masyarakat |
| `queue_numbers` | Nomor antrian pasien |
| `applications` | Konfigurasi aplikasi |
| `pengaduans` | Data pengaduan masyarakat |
| `sosialisasi` | Data kegiatan sosialisasi |
| `messages` | Pesan / broadcast |

---

## Role Pengguna

| Role | Akses |
|---|---|
| **Admin** | Akses penuh ke seluruh fitur admin |
| **Kepala BNN** | Akses dashboard & laporan |
| **Masyarakat (User)** | Dashboard masyarakat & pengaduan |
| **Guest** | Halaman landing & peta publik (`/peta`) |

---

## Peta Interaktif

Aplikasi menyediakan 3 jenis peta interaktif berbasis Google Maps:

1. **Peta Kerawanan** — Warna berdasarkan jumlah orang positif narkoba:
   - 🔴 Merah: ≥ 10 orang
   - 🟡 Kuning: 5–9 orang
   - 🟢 Hijau: 0–4 orang

2. **Peta Sosialisasi** — Warna berdasarkan status sosialisasi:
   - 🔵 Biru: Sudah disosialisasi
   - 🔴 Merah: Belum disosialisasi

3. **Peta Jenis Narkoba** — Warna berdasarkan golongan narkoba:
   - 🔴 Merah: Golongan I
   - 🟡 Kuning: Golongan II
   - ⚫ Hitam: Semua golongan
   - Dan kombinasi lainnya

### Fitur Peta
- Pencarian per kecamatan (Select2 real-time search)
- Kontrol skala peta (slider + zoom in/out)
- Transparansi blok (opacity slider)
- Street View
- Hover info panel per desa
- Klik untuk zoom ke desa
- Tombol reset peta

---

## Lisensi

Proyek ini dikembangkan oleh Frankie Steinlie untuk **BNN Kabupaten Kediri**.
