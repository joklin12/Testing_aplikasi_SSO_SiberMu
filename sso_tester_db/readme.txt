Penjelasan :
- Fungsi aplikasi sso_tester_db untuk mengetes/menguji cara koneksi aplikasi lain ke web sso.sibermu.ac.id
- aplikasi sso_tester_db di desain menggunakan database (file dn : user_tes_sso_sibermu.sql), syarat penggunaanya bisa menggunakan web server apache/NginX, database mysql/mariadb
- Diharapkan developer bisa memahami cara kerja dari sso.sibermu.ac.id sehingga bisa mengimplementasikan ke semua aplikasi yang sudah di buat dengan login menggunakan satu akun saja
- SSO ini bisa di gunakan untuk banyak aplikasi tanpa batas
- seluruh data sensitif yang tersimpan di sso.sibermu.ac.id terinkripsi
- SSO ini berkomunikasi menggunakan token, domain aplikasi dan bisa di filter berdasarkan institusi (ruang lingkup kecil)/organisasi (lingkup lebih besar)/ (user yang tidak sama dengan institusinya/organisasinya akan di tolak login)
- institusi/organisasi di kosongi maka semua user yang terdaftar di sso.sibermu.ac.id bisa mengakses aplikasi anda
- SSO ini testernya institusi : SMA 1 TESTING, di luar institusi tersebut akan di tolak login, akun tester sudah disediakan.
- sso.sibermu.ac.id memiliki fitur memanajemen terpusat berupa suspend per user dan suspend per domain / bisa juga suspen per domain
- Setiap admin organisasi bisa memanage akun organisasinya secara mandiri (upload, hapus, generate web servis token, manage domain dll) 
- fungsi utama untuk berkomunikasi ke sso.sibermu.ac.id adalah callback.php untuk dashboard.php, index.php, logout.php sebagai tambahan
- developer cukup membuat tombol "Login with SSO" kodenya ada di index.php
- syarat untuk melakukan pengujian ini wajib menggunakan url : localhost/sso_tester_db , di luar url ini, atau nama lain akan di blok
- aplikasi ini sumber terbuka, boleh di modifikasi dan tidak di perkenankan untuk di perjual belikan
- pengujian (akun tester) gunakan:
	Organisasi : SMA 1 TESTING
 	username : testing2025
	password : 123456

	ORGANISASI : SIBERMU => seharusnya ditolak/tidak bisa login karena di blok
	username : testing22025
	password : 123456
Melihat profile user bisa dari https://sso.sibermu.ac.id masukkan username dan password
------------------------------------------------------------------------------
salam tim BSI (Biro Sistem Informasi) Universitas Siber Muhammadiyah (SiberMu)
Pengabdian Masyarakat SiberMu :
Joko Supriyanto M.Kom &
Andi Suganti M.Kom

