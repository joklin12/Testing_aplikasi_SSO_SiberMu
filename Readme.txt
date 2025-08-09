SSO SiberMu adalah Sistem Otentikasi Terpadu (SSO) Berbasis Token dan Validasi Domain untuk Layanan Multi-Organisasi yang dirancang untuk memberikan akses aman dan terintegrasi ke berbagai layanan digital di lingkungan SiberMu dan organisasi lain yang membutuhkan. Dengan satu kali login, pengguna dapat dengan mudah mengakses semua platform yang terhubung tanpa perlu memasukkan ulang kredensial.
alamat server SSO : https://sso.sibermu.ac.id
---------------------------------------------------------------------
folder
-sso_tester_xx adalah aplikasi untuk mengambil data dari SSO untuk login di aplikasi yang anda buat
-sso_post adalah api yang digunakan dari aplikasi anda untuk menginsert data ke sso.sibermu.ac.id misalkan anda punya aplikasi penerimaan mahasiswa baru model web setiap mahasiswa yang dapat NIM otomatis akan di insert data id unik, nama, pekerjaan, alamat, password, no hp di sso.sibermu.ac.id tanpa harus mengimport manual di excel
---------------------------------------------------------------------
Petunjuk pengujian :
Pilih salah satu 
	- Paling praktis tanpa database pilih folder : sso_tester_nodb
	- Jika ingin menggunakan database pilih folder : sso_tester_db
	- Jika login pagenya tidak menggunakan "index.php" misal login.php pilih folder : sso_tester_noindex
--------------------------------------------------------------------
Petunjuk lengkap ada di dalam folder masing-masing
Petunjuk developer : file intinya cuma satu yaitu callback.php yang lain hanya sebagai pelengkap
--------------------------------------------------------------------
Plugin Moodle = https://github.com/joklin12/Plugin-moodle-SSO-SiberMu
Plugin di website resmi Moodle : https://moodle.org/plugins/auth_sso_sibermu (Under Review)
--------------------------------------------------------------------
Testing langsung silakan akses di : https://demossosibermu.jokode.my.id/
--------------------------------------------------------------------
	
