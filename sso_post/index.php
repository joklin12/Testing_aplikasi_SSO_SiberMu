<?php
/**
 * Aplikasi Klien Sederhana untuk Mengirim Data User Baru
 * ke API SSO SiberMu menggunakan metode POST.
 */

// 1. Konfigurasi
// -------------------------------------------------------------
// URL endpoint API yang akan dituju.
// Ganti dengan URL asli jika sudah di-deploy.
$api_url = 'https://sso.sibermu.ac.id/api_create_user.php'; //url server sso sibermu pastikan sso.sibermu.ac.id

// URL aplikasi klien. PENTING: Domain ini harus terdaftar dan aktif
// pada `url_terdaftar` untuk token yang digunakan di bawah.
// API akan memvalidasi header 'Referer' dari permintaan.
$client_app_url = 'http://localhost/sso_post/index.php'; // pastikan url ini didaftarkan juga di sso.sibermu.ac.id

// Data pengguna baru yang akan dikirim.
$user_data = [
    // Gunakan token API yang valid.
    'api_token' => 'token_anda_dari_sso SiberMu', //diambil dari sso.sibermu.ac.id dan pastikan switch "post" aktif - wajib anda jadi admin
    'nisn'      => 'man2btl-011', // <-- TAMBAHKAN ID Unik DI SINI
    'nama'      => 'Zainal Abidin',
    'password'  => '123456',
    'pekerjaan' => 'Siswa',
    'no_hp'     => '081122334455',
    'alamat'    => 'Jl. Merdeka No. 17, Bandung'
];
// -------------------------------------------------------------


// 2. Persiapan Request cURL
// -------------------------------------------------------------
// Ubah array data menjadi format string JSON.
$payload = json_encode($user_data);

// Inisialisasi cURL.
$ch = curl_init();

// Set opsi untuk request cURL.
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_POST, true); // Menentukan metode sebagai POST.
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // Mengisi body request dengan data JSON.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Mengembalikan respon sebagai string.

// Set header yang diperlukan.
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json', // Memberi tahu server bahwa kita mengirim JSON.
    'Content-Length: ' . strlen($payload)
]);

// Set Referer untuk lolos dari validasi di sisi API.
curl_setopt($ch, CURLOPT_REFERER, $client_app_url);

// -------------------------------------------------------------


// 3. Eksekusi dan Tampilkan Hasil
// -------------------------------------------------------------
echo "<html><head><title>Test API Client</title>";
echo "<style>body { font-family: sans-serif; line-height: 1.6; } pre { background-color: #f4f4f4; padding: 15px; border-radius: 5px; } </style>";
echo "</head><body>";
echo "<h1>Test API Client untuk SSO SiberMu</h1>";

echo "<h2>Data yang Dikirim:</h2>";
echo "<pre>" . htmlspecialchars(json_encode($user_data, JSON_PRETTY_PRINT)) . "</pre>";

// Eksekusi request.
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Ambil status kode HTTP.

echo "<h2>Respon dari Server:</h2>";

// Cek jika ada error pada cURL.
if (curl_errno($ch)) {
    echo "<h3>Error cURL!</h3>";
    echo "<pre>Error: " . curl_error($ch) . "</pre>";
} else {
    // Tampilkan status kode dan body respon.
    echo "<b>HTTP Status Code:</b> " . $http_code . "<br>";
    echo "<b>Body Respon:</b>";
    // Coba decode JSON untuk tampilan yang lebih rapi.
    $json_response = json_decode($response, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "<pre>" . htmlspecialchars(json_encode($json_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) . "</pre>";
    } else {
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
    }
}

// Tutup koneksi cURL.
curl_close($ch);

echo "</body></html>";


?>

