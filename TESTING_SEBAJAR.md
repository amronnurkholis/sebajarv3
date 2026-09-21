# Sebajar — Konfigurasi Sebelum Testing

Versi ini sudah menyambungkan menu **Pengguna**, **Pengaturan**, dan **Pesanan** serta menghubungkan setiap rental baru ke akun user melalui `rentals.user_id`.

## 1. Prasyarat

Pastikan tersedia:

- PHP 8.3+
- Composer
- Node.js + npm
- MySQL/MariaDB jika mengikuti konfigurasi database Sebajar

## 2. Siapkan project

Setelah mengekstrak ZIP:

```bash
composer install
npm install
```

Project sengaja tidak menyertakan `vendor/` dan `node_modules/` agar paket yang terpasang mengikuti environment komputer yang dipakai untuk testing.

## 3. Buat `.env`

Salin:

```bash
cp .env.example .env
php artisan key:generate
```

Kemudian sesuaikan database. Contoh MySQL lokal:

```env
APP_NAME=Sebajar
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sebajar
DB_USERNAME=root
DB_PASSWORD=
```

Jangan memasukkan password database production ke repository atau ZIP yang dibagikan.

## 4. Database

Buat database kosong bernama `sebajar`, lalu jalankan:

```bash
php artisan migrate
```

Jika menggunakan database Sebajar yang sudah berisi data lama, **jangan menjalankan `migrate:fresh`** karena perintah tersebut akan menghapus seluruh tabel.

Migration baru:

```text
database/migrations/2026_08_19_000000_add_user_id_to_rentals_table.php
```

Migration ini menambahkan `user_id` ke rental lama sebagai nullable sehingga data rental lama tetap aman. Rental baru akan menyimpan ID user yang sedang login.

## 5. Storage dan asset

Jalankan:

```bash
php artisan storage:link
npm run build
```

Untuk development dengan Vite:

```bash
npm run dev
```

## 6. Bersihkan cache Laravel sebelum testing

```bash
php artisan optimize:clear
```

Kemudian jalankan server:

```bash
php artisan serve
```

## 7. Skenario testing utama

### Customer

1. Register akun customer.
2. Login.
3. Buka beranda.
4. Pastikan tombol **Pesanan** / ikon tas muncul.
5. Buka Koleksi.
6. Pilih kostum.
7. Isi form penyewaan dan ukuran.
8. Kirim pengajuan.
9. Buka **Pesanan**.
10. Pastikan pengajuan muncul dengan status **Menunggu Persetujuan**.

### Admin

1. Login menggunakan akun admin.
2. Buka Dashboard.
3. Pastikan menu **Pengguna** membuka `/admin/users`.
4. Pastikan tambah/edit/hapus pengguna bekerja.
5. Pastikan menu **Pengaturan** membuka `/admin/settings`.
6. Ubah nama akun atau password jika diperlukan.
7. Buka **Pengajuan Sewa**.
8. Approve pengajuan customer.

### Customer setelah approval

Refresh halaman **Pesanan**.

Status yang diharapkan:

```text
pending   -> Menunggu Persetujuan
approved  -> Sedang Disewa
completed -> Selesai
rejected  -> Ditolak
```

## 8. Pemeriksaan penting

Pastikan rental baru memiliki:

```text
rentals.user_id = users.id
```

Relasi yang digunakan:

```text
User hasMany Rental
Rental belongsTo User
```

## 9. Catatan tentang tombol "Keranjang"

UI menggunakan ikon `shopping_bag` dengan label **Pesanan**, bukan cart e-commerce. Alasannya karena Sebajar menyimpan pengajuan rental yang sudah dikirim, bukan daftar barang sebelum checkout.

Badge pada tombol menampilkan jumlah pengajuan yang masih `pending`; jika tidak ada pending, badge menampilkan jumlah seluruh pesanan user.

## 10. Pemeriksaan sebelum deployment

Sebelum production:

```bash
php artisan optimize:clear
npm run build
php artisan migrate --force
php artisan storage:link
```

Production harus menggunakan:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sebajar.store
```

Gunakan database production sendiri dan jangan membawa `.env` lokal ke server.
