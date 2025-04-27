# 🚀 Laravel API Backend RBAC

Ini adalah backend API menggunakan **Laravel**, database **MySQL**, menggunakan **JWT Authentication**, dan sudah tersedia **seeder** untuk akun Superadmin, Admin, dan User.

---

## 📦 Cara Install Project

Ikuti langkah-langkah berikut:

### 1. Clone Project

```bash
git clone https://github.com/username/nama-project.git
```

Ganti `username/nama-project.git` sesuai alamat repository kamu.

### 2. Masuk ke Folder Project

```bash
cd nama-project
```

### 3. Install Dependency

```bash
composer install
```

> Pastikan `composer` sudah terinstall di komputer kamu.  
Kalau belum, bisa download dari [getcomposer.org](https://getcomposer.org/).

### 4. Copy File `.env`

Buat file `.env` baru dari contoh `.env.example`.

```bash
cp .env.example .env
```

### 5. Atur Koneksi Database

Buka file `.env`, lalu sesuaikan bagian database:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

> Ganti `nama_database`, `root`, dan `password` sesuai setting MySQL kamu.

### 6. Generate Application Key

```bash
php artisan key:generate
```

### 7. Jalankan Migrasi Database

Ini untuk membuat semua tabel yang dibutuhkan:

```bash
php artisan migrate
```

### 8. Jalankan Seeder

Untuk mengisi database dengan akun Superadmin, Admin, dan User:

```bash
php artisan db:seed
```

### 9. Install JWT Authentication

Kalau belum diinstall, jalankan:

```bash
composer require tymon/jwt-auth
```

Setelah itu publish config:

```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

Generate secret key JWT:

```bash
php artisan jwt:secret
```

> Ini akan membuat `JWT_SECRET` otomatis di file `.env`.

---

## 🔐 Akun Login yang Tersedia

| Role        | Email                      | Password    |
|-------------|-----------------------------|-------------|
| Superadmin  | superadmin@example.com       | 123123123   |
| Admin       | admin@example.com            | 123123123   |
| User        | user@example.com             | 123123123   |

---

## 🛠️ Menjalankan Server

Untuk menjalankan server Laravel:

```bash
php artisan serve
```

Nanti akan jalan di:

```
http://localhost:8000
```

API endpoint kamu akan mulai dari `http://localhost:8000/api`.

---

## 📂 Struktur Penting

- `app/Models/` → Model database
- `app/Http/Controllers/` → Tempat Controller (mengatur logic API)
- `routes/api.php` → Semua route API ditaruh di sini
- `database/seeders/` → Tempat file seeder akun awal
- `config/jwt.php` → Konfigurasi JWT

---

## 💬 FAQ

**Q: Gagal konek database?**  
A: Cek lagi file `.env` kamu, pastikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` benar.

**Q: Error "Could not find driver (MySQL)"?**  
A: Pastikan ekstensi `pdo_mysql` sudah aktif di PHP.

**Q: Login gagal, token tidak muncul?**  
A: Pastikan kamu sudah `php artisan jwt:secret` dan pakai endpoint login yang benar (`/api/login`).

---

## ⚡ Tips Tambahan

- Setiap kali ada perubahan pada file `.env`, **restart** server Laravel (`php artisan serve`) agar perubahan terbaca.
- Kalau ada error permission, coba jalankan:

```bash
chmod -R 775 storage bootstrap/cache
```

- Untuk reset database, bisa pakai:

```bash
php artisan migrate:fresh --seed
```
(**hapus semua data dan buat ulang**)

---

# 🎯 Selamat ngoding Laravel + JWT! 🚀

---
