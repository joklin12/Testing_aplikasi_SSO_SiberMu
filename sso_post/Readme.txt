- aplikasi ini digunakan untuk jembatan menginsert data dari aplikasi anda ke sso.sibermu tanpa harus mengimport data melalui excel.
- misalkan anda memiliki aplikasi pmb.sibermu.ac.id (penerimaan mahasiswa baru aplikasi berbasis web) setiap mahasiswa yang sudah diterima/mendapatkan nim maka otomatis akan dapat username dan password dari sso.sibermu.ac.id amaka aplikasi ini sebagai jembatannya
-----------------------------------------------------------------------
syarat pentingnya :
- anda sudah memiliki akun level admin di sso.sibermu.ac.id
- anda sudah membuat token di sso.sibermu.ac.id
- domaian anda sudah didaftarkan ke sso.sibermu.ac.id dan pastikan switch "post" kondisi "on"
- pendaftaran domain harus lengkap/sama persis jika tidak sama maka insert kedatabase sso.sibermu.ac.id bakal gagal, misalkan kalau di contoh ini : http://localhost/sso_post/index.php
- Untuk institusi dan Organisasi otomatis akan di insert sesuai admin yang didaftarkan atau di kontol oleh super admin. 
- Admin tidak bisa mengubah Institusi dan organisasi