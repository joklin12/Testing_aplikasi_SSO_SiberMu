Aplikasi di file index.php ini adalah klien sederhana yang tugasnya mengirimkan data pengguna baru ke API SSO SiberMu menggunakan metode POST. DiSiberMu SSO SiberMu hanya sebagai backup jikalau layanan google tumbang/bermasalah, BUKAN metode utama creat akun. setelah layanan google normal pastikan user yang di creat SSO SIberMu dikirim ke google sebagai akun utama dan SSO SiberMu ini dinonaktifkan

Penjelasan sederhananya:
Konfigurasi awal
-Menentukan URL API SSO ($api_url), yaitu alamat server tujuan yaitu : https://sso.sibermu.ac.id/api_create_user.php
-Menentukan URL aplikasi klien ($client_app_url) yang harus sudah terdaftar di server SSO, wajib di ketik lengkap beserta file yg buat post untuk keamanan misal : http://localhost/sso_post/index.php, jangan http://localhost karena file post bia ada dimana saja dan akan selalu di accept oleh sso sibermu dikhawatirkan ada yang menginsert file post dari luar
-Menyediakan data pengguna baru ($user_data) seperti NISN, nama, password, pekerjaan, nomor HP, dan alamat. untuk SiberMu NISN : akun email google, password buat email google
-Menyertakan API token agar request diizinkan oleh server.

Mengirim data:
Data diubah menjadi format JSON.
Menggunakan cURL untuk mengirim data ke API.
API SSO akan memprosesnya, memvalidasi token & domain, lalu membuat akun di sistem SSO.

Tujuan:
Memudahkan pendaftaran akun ke sistem SSO secara otomatis tanpa input manual di server.
Kalau diibaratkan, ini seperti form pendaftaran otomatis yang mengirimkan data ke pusat SSO, asalkan punya token sah dan domain sudah terdaftar di SSO SiberMu.
-----------------------------------------------------------------------
- aplikasi ini digunakan untuk jembatan menginsert data dari aplikasi anda ke sso.sibermu tanpa harus mengimport data melalui excel.
- misalkan anda memiliki aplikasi pmb.sibermu.ac.id (penerimaan mahasiswa baru aplikasi berbasis web) setiap mahasiswa yang sudah diterima/mendapatkan nim maka otomatis akan dapat username dan password dari sso.sibermu.ac.id maka aplikasi ini sebagai jembatannya
-----------------------------------------------------------------------
syarat pentingnya (gambar telampir) :
- anda sudah memiliki akun level admin di sso.sibermu.ac.id
- anda sudah membuat token di https://sso.sibermu.ac.id
- domaian anda sudah didaftarkan ke https://sso.sibermu.ac.id dan pastikan switch "post" kondisi "on"
- pendaftaran domain harus lengkap/sama persis jika tidak sama maka insert kedatabase sso.sibermu.ac.id bakal gagal, misalkan kalau di contoh ini : http://localhost/sso_post/index.php
- Untuk institusi dan Organisasi otomatis akan di insert sesuai admin yang didaftarkan oleh super admin untuk konsistensi data dan bisaa di gunakan sebagai filtering login di aplikasi yang anda buat. 
- Admin tidak bisa mengubah Institusi dan organisasi

-----------------------------------------------------------------------
Plugin Moodle = https://github.com/joklin12/Plugin-moodle-SSO-SiberMu
Testing langsung silakan akses di : https://demossosibermu.jokode.my.id/