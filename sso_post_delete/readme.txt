Penjelasan sederhananya:
Konfigurasi awal
-Menentukan URL API SSO ($api_url), yaitu alamat server tujuan yaitu : https://sso.jokode.my.id/api_delete_user.php dan pastikan saat diakses langsung muncul {"success":false,"error":"Metode tidak diizinkan. Gunakan POST."} menandakan sudah aktif siap terima data dari aplikasi anda
-Menentukan URL aplikasi klien ($client_app_url) yang harus sudah terdaftar di server SSO, wajib di ketik lengkap beserta file yg buat post untuk keamanan misal : http://localhost/sso_post_delete/hapus_user_interface.php, jangan http://localhost karena file post bia ada dimana saja dan akan selalu di accept oleh sso sibermu dikhawatirkan ada yang menginsert file post dari luar. WAJIB switch POST on
-Menyediakan data pengguna yaitu cukup NISN saja
-Menyertakan API token agar request diizinkan oleh server.
