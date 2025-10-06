# 📚 Library Booking App

Aplikasi web berbasis PHP (MVC) untuk manajemen peminjaman ruangan perpustakaan, dikembangkan sebagai bagian dari **Project-Based Learning (PBL)**  
Program Studi **Teknik Informatika – Politeknik Negeri Jakarta (PNJ)**.

---

## ⚙️ Kebutuhan Sistem

| Komponen | Versi Minimum |
|-----------|----------------|
| PHP | 8.1+ |
| Composer | Terbaru |
| MySQL / MariaDB | 10+ |

Pastikan ekstensi PHP berikut aktif:
- `pdo_mysql`
- `openssl`
- `mbstring`
- `intl`
- `tokenizer`

---

## 🚀 Langkah Menjalankan Aplikasi (Dari Awal Sampai Jalan)

Ikuti langkah-langkah berikut secara urut dari awal clone sampai aplikasi benar-benar bisa diakses di browser.

### 1️⃣ Clone Repository
```bash
git clone https://github.com/MohammadRizkiSyahputra/library-booking-app.git
cd library-booking-app
```

### 2️⃣ Install Dependency Composer
```bash
composer install
```

### 3️⃣ Buat dan Atur File `.env`
Salin file contoh `.env.example` jadi `.env`:
```bash
cp .env.example .env
```

Kemudian buka `.env` dan ubah sesuai konfigurasi lokal kamu:
```ini
# Konfigurasi Database
DB_DSN = mysql:host=localhost;port=3306;dbname=library_booking_app
DB_USER = root
DB_PASSWORD =

# Konfigurasi Email 
MAIL_USER = yourgmail@gmail.com
MAIL_PASS = your_gmail_app_password
```

💡 **Tips:**  
Kamu bisa membuat sandi aplikasi Gmail di sini 👉 [https://myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)  
Pastikan **Verifikasi 2 Langkah** di akun Google kamu sudah aktif.  

---

### 4️⃣ Buat Database di MySQL / MariaDB
Masuk ke terminal MySQL, lalu jalankan:
```sql
CREATE DATABASE library_booking_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### 5️⃣ Jalankan Migrasi Database
Perintah ini akan membuat seluruh tabel yang dibutuhkan:
```bash
php migration.php
```
Contoh hasil:
```
> Applying migration: 2024_00_create_users_table
> Migration applied successfully.
```

---

### 6️⃣ Jalankan Server PHP
Gunakan server bawaan PHP:
```bash
php -S localhost:8000 -t public
```

Setelah itu buka browser dan akses:
👉 **http://localhost:8000**

Jika konfigurasi sudah benar, aplikasi **Library Booking App** akan tampil di halaman utama.

---

### 7️⃣ Uji Alur Aplikasi
1. Registrasi menggunakan email PNJ (`@stu.pnj.ac.id` atau `<jurusan>.pnj.ac.id`)  
2. Cek email untuk menerima kode verifikasi  
3. Masukkan kode tersebut di halaman **Verifikasi Akun**  
4. Setelah berhasil diverifikasi, login ke dashboard  
5. Coba fitur **Lupa Password → Reset Password** untuk memastikan pengiriman email berjalan

---

## 🧠 Struktur Folder
```
app/
 ├── controllers/     → Mengatur logika request (Auth, Password, Verify, dll)
 ├── core/            → File inti framework (App, Controller, Model, Router)
 ├── models/          → Model data & validasi
 ├── views/           → Template tampilan (auth, dashboard, dll)
 └── services/        → Service helper (EmailService, dll)

public/
 ├── index.php        → Entry point aplikasi
 ├── js/              → File JavaScript (verify.js, dll)
 └── assets/          → File statis (CSS, gambar, dll)

routes/
 └── web.php          → Definisi route web

.env.example          → Contoh file konfigurasi environment
migration.php         → Skrip migrasi database
composer.json         → Dependency & autoload Composer
```

---

## 💌 Konfigurasi Email (Gmail / SMTP)

Jika menggunakan Gmail:
1. Aktifkan **Verifikasi 2 Langkah** di akun Google  
2. Buka [https://myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)  
3. Pilih **Other (Custom name)** → beri nama misalnya `LibraryApp`  
4. Salin sandi 16 karakter yang muncul, lalu tempel ke `.env` pada `MAIL_PASS`

Contoh konfigurasi:
```ini
MAIL_USER = yourgmail@gmail.com
MAIL_PASS = abcd efgh ijkl mnop
```

---

## 🧾 Lisensi

Proyek ini dibuat untuk keperluan **pembelajaran dan pengembangan akademik (PBL)**  
pada **Politeknik Negeri Jakarta**, Program Studi **Teknik Informatika (TI)**.

© 2025 Kelompok 3 PBL — All Rights Reserved.


