# **[E-Voting - Sistem Pemilihan Online](https://github.com/rafsanza-hub/voting-system/)**



**E-Voting** adalah aplikasi berbasis web yang memungkinkan pengguna untuk melakukan pemilihan secara online dengan aman dan efisien. Aplikasi ini menyediakan fitur untuk memilih calon, melihat hasil pemilihan secara real-time, dan memastikan transparansi serta keamanan proses pemilu.

## Framework dan Library Yang Digunakan
- [CodeIgniter 4](https://codeigniter.com/)
- [Myth/Auth](https://github.com/lonnieezell/myth-auth)
- [Bootstrap 5](https://getbootstrap.com/)
- [Stisla Admin Template](https://github.com/pixinvent/sneat-bootstrap-html-admin-template-free)

## Fitur Utama
- **Pemilihan Online**: Pengguna dapat memilih kandidat secara online dengan sistem yang aman dan cepat.
- **Hasil Voting Real-time**: Pemilih dapat melihat hasil pemilihan secara langsung.
- **Keamanan dan Otorisasi Pengguna**: Menggunakan sistem otentikasi berbasis [Myth/Auth](https://github.com/lonnieezell/myth-auth) untuk menjaga integritas pemilih dan hasil.
- **Dashboard Admin**: Admin dapat mengelola kandidat dan melihat statistik pemilu dengan mudah.

## Cara Penggunaan

### Persyaratan
Pastikan perangkat Anda memiliki:
- **PHP 8.1+** dan **MySQL** atau **XAMPP versi 8.1+** dengan extension `intl` dan `gd` diaktifkan.
- **Composer** untuk manajemen dependensi.

### Instalasi

Ikuti langkah-langkah berikut untuk menginstal aplikasi sistem pemilihan online ini:

1. **Unduh dan Impor Kode Project**
   - Salin atau unduh kode project ini ke direktori project Anda, misalnya `htdocs` pada XAMPP.

2. **Konfigurasi File `.env`**
   - Jika belum memiliki file `.env`, salin file `env` menjadi `.env`.
   - **Penting ⚠️**: Pastikan untuk menyesuaikan pengaturan di file `.env`, terutama untuk koneksi database, agar sesuai dengan lingkungan pengembangan Anda.

3. **Instalasi Dependensi**
   - Jalankan perintah berikut di terminal untuk menginstal semua dependensi yang diperlukan:

     ```bash
     composer install
     ```

4. **Membuat Database**
   - Buat database baru di phpMyAdmin atau MySQL, dengan nama `myvote`.

5. **Menjalankan Migrasi Database**
   - Jalankan perintah migrasi untuk membuat tabel-tabel yang diperlukan di database. Ketikkan perintah berikut di terminal:

     ```bash
     php spark migrate --all
     ```

6. **Menambahkan Data Login**
   - Jalankan perintah berikut untuk menambahkan data pengguna:

     ```bash
     php spark db:seed AllSeeder
     ```

7. **Menjalankan Website**
   - Setelah semua terinstal, jalankan server aplikasi menggunakan perintah berikut:

     ```bash
     php spark serve
     ```

8. **Akses Aplikasi**
   - Buka aplikasi melalui browser di [http://localhost:8080](http://localhost:8080).

9. **Login dengan Akun Admin**
    - Gunakan akun berikut untuk mengakses aplikasi:

     ```txt
     username : admin
     password : admin123
     ```

---

### Catatan Tambahan

- Pastikan telah memeriksa dan mengonfigurasi database serta file `.env` dengan benar agar aplikasi dapat berjalan lancar.
- Pastikan juga untuk mengatur pemilihan kandidat, serta status pemilihan di sistem, untuk menjalankan pemilihan dengan lancar.

---
