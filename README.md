# Sistem Manajemen Akun – UTS Pemrograman Web Lanjut 2026

Aplikasi web manajemen akun, tipe akun, dan jenis aksi berbasis **PHP Native (Tanpa MVC)** dengan basis data **MySQL**, sesuai dengan spesifikasi soal UTS Pemrograman Web Lanjut 2026 Teknik Informatika Politeknik Negeri Jakarta.

---

## 1. Identitas Mahasiswa & Database

- **Nama**: Farkhan Abdillah
- **Kelas / Angkatan**: TI 3B / 2026
- **Nama Database**: `PBL_TI_2026_B_FARKHANABDILLAH`
- **Sifat Ujian**: Praktik & Presentasi

---

## 2. Struktur Direktori & Berkas

Struktur berkas dirapikan per modul fitur sehingga mudah dipahami:

```text
UTS_Pemrograman_Web_Lanjut_2026/
├── akun/                     # Modul Manajemen Akun
│   ├── index.php             # Tabel daftar akun & pencarian
│   ├── tambah.php            # Form tambah akun baru
│   ├── edit.php              # Form ubah data akun
│   └── hapus.php             # Soft delete akun
├── tipe_akun/                # Modul Manajemen Tipe Akun
│   ├── index.php             # Tabel daftar tipe akun & pencarian
│   ├── tambah.php            # Form tambah tipe akun
│   ├── edit.php              # Form ubah tipe akun
│   └── hapus.php             # Soft delete tipe akun
├── aksi/                     # Modul Manajemen Jenis Aksi
│   ├── index.php             # Tabel daftar jenis aksi & pencarian
│   ├── tambah.php            # Form tambah jenis aksi
│   ├── edit.php              # Form ubah jenis aksi
│   └── hapus.php             # Soft delete jenis aksi
├── header.php                # Navigasi atas, cek sesi login, & styling
├── koneksi.php               # Koneksi database MySQLi & fungsi UUID v4
├── index.php                 # Pengarah awal (redirect ke akun atau login)
├── login.php                 # Form & proses login autentikasi
├── logout.php                # Proses keluar sistem
├── database.sql              # Skrip SQL tabel & data awal
└── init_db.php               # Skrip instalasi database instan
```

---

## 3. Fitur Sesuai Spesifikasi Soal

1. **Database Design (Bobot 30)**:
   - Format nama database: `PBL_TI_2026_B_FARKHANABDILLAH`
   - Primary Key: UUID (String 36) pada seluruh tabel (`accounts`, `account_type`, `actions`).
   - Relasi: Kolom `account_type_id` pada tabel `accounts` berelasi ke tabel `account_type`.
   - Kolom wajib: `created_at` (DATETIME), `updated_at` (DATETIME), dan `deleted_at` (DATETIME) untuk soft delete.

2. **Aturan Sistem & Fungsionalitas (Bobot 55)**:
   - Login menggunakan email dan kata sandi (`password_verify` & `password_hash`).
   - Form tambah, ubah, dan soft delete data akun.
   - Daftar akun dengan pencarian multikolom (nama, email, identitas NIM/NIP, tipe akun).
   - Form tambah, ubah, dan soft delete data tipe akun.
   - Daftar tipe akun dengan pencarian.
   - Form tambah, ubah, dan soft delete data tipe aksi.
   - Daftar tipe aksi dengan pencarian.

---

## 4. Cara Menjalankan Aplikasi

### Opsi 1: Lewat XAMPP
1. Aktifkan **Apache** dan **MySQL** di XAMPP Control Panel.
2. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
3. Buat database `PBL_TI_2026_B_FARKHANABDILLAH` atau import file `database.sql`.
4. Letakkan folder ini di `C:\xampp\htdocs\`.
5. Akses melalui peramban web: `http://localhost/UTS_Pemrograman_Web_Lanjut_2026/`.

### Opsi 2: Menggunakan PHP Built-in Server
1. Buka terminal di folder project.
2. Inisialisasi database:
   ```bash
   php init_db.php
   ```
3. Jalankan server lokal:
   ```bash
   php -S localhost:8000
   ```
4. Buka di browser: `http://localhost:8000`.

---

## 5. Akun Default untuk Login

- **Email**: `admin@pnj.ac.id`
- **Password**: `Admin#2026`
- **Peran**: Administrator (NIP: `520000000000000746`)
