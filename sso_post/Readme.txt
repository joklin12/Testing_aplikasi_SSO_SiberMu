Aplikasi di file index.php ini adalah klien sederhana yang tugasnya mengirimkan data pengguna baru ke API SSO SiberMu menggunakan metode POST.

Penjelasan sederhananya:
Konfigurasi awal
Menentukan URL API SSO ($api_url), yaitu alamat server tujuan.
Menentukan URL aplikasi klien ($client_app_url) yang harus sudah terdaftar di server SSO.
Menyediakan data pengguna baru ($user_data) seperti NISN, nama, password, pekerjaan, nomor HP, dan alamat.
Menyertakan API token agar request diizinkan oleh server.

Mengirim data:
Data diubah menjadi format JSON.
Menggunakan cURL untuk mengirim data ke API.
API SSO akan memprosesnya, memvalidasi token & domain, lalu membuat akun di sistem SSO.

Tujuan:
Memudahkan pendaftaran akun ke sistem SSO secara otomatis tanpa input manual di server.
Kalau diibaratkan, ini seperti form pendaftaran otomatis yang mengirimkan data ke pusat SSO, asalkan punya token sah dan domain sudah terdaftar.
-----------------------------------------------------------------------
- aplikasi ini digunakan untuk jembatan menginsert data dari aplikasi anda ke sso.sibermu tanpa harus mengimport data melalui excel.
- misalkan anda memiliki aplikasi pmb.sibermu.ac.id (penerimaan mahasiswa baru aplikasi berbasis web) setiap mahasiswa yang sudah diterima/mendapatkan nim maka otomatis akan dapat username dan password dari sso.sibermu.ac.id amaka aplikasi ini sebagai jembatannya
-----------------------------------------------------------------------
syarat pentingnya :
- anda sudah memiliki akun level admin di sso.sibermu.ac.id
- anda sudah membuat token di sso.sibermu.ac.id
- domaian anda sudah didaftarkan ke sso.sibermu.ac.id dan pastikan switch "post" kondisi "on"
- pendaftaran domain harus lengkap/sama persis jika tidak sama maka insert kedatabase sso.sibermu.ac.id bakal gagal, misalkan kalau di contoh ini : http://localhost/sso_post/index.php
- Untuk institusi dan Organisasi otomatis akan di insert sesuai admin yang didaftarkan atau di kontrol oleh super admin. 
- Admin tidak bisa mengubah Institusi dan organisasi

-----------------------------------------------------------------------
