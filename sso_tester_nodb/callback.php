<?php
/**
 * @package     Testing SSO Sibermu
 * @author      Joko Supriyanto <joko@sibermu.ac.id>
 * @copyright   Copyright (C) Juni 2025 Biro Sistem Informasi SiberMu. All rights reserved.
 * @license     GPLv3
 */
 
session_start();

$code = $_GET['code'] ?? null;

if (empty($code)) {
    // Alihkan kembali ke halaman login utama dengan pesan error
    header('Location: index.php?error=auth_failed');
    exit; // Pastikan untuk keluar setelah redirect
}

$sso_server_url = 'https://sso.sibermu.ac.id'; // Web SSO SiberMu
$verify_url = $sso_server_url . '/api/verify_code.php';

// Inilah bagian server-to-server communication menggunakan cURL
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $verify_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['code' => $code]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);

// Cek apakah penukaran tiket berhasil (HTTP code 200) dan response sukses
if ($http_code === 200 && isset($data['success']) && $data['success']) {
    // SUKSES! Data user diterima.
    $user_data = $data['user'];

    // --- PENGECEKAN Institusi (ruang lingkup lebih kecil) --- anda bisa juga pengecekan organisasi (ruang lingkupnya lebih luas)
    // Ganti dengan nama Institusi/organisasi yang Anda izinkan.
    $allowed = 'SMA 1 TESTING'; 

    if (isset($user_data['institusi']) && $user_data['institusi'] === $allowed) { // untuk ambil organisasi cukup ganti {institusi} ke [organisasi]
		// Ambil data 'admin_aplikasi' dari respons JSON dan tambahkan ke array data pengguna.
		//$user_data['admin_aplikasi'] = $data['admin_aplikasi'] ?? 'Admin Tidak Ditemukan';
        // Institusi sesuai, simpan data user ke session dan lanjutkan.
        $_SESSION['user'] = $user_data;

        // Arahkan ke halaman dashboard
        header('Location: dashboard.php');
        exit;
    } else {
        // Institusi tidak sesuai, tolak login.
        // HANCURKAN SESI LOKAL SEBELUM REDIRECT
        session_unset();
        session_destroy();
        
        // Redirect kembali ke halaman login dengan pesan error.
        header('Location: index.php?error=org_mismatch');
        exit;
    }
    // --- AKHIR PENGECEKAN ---

} else {
    // Gagal, tampilkan pesan error
    echo "<h1>Login Gagal!</h1>";
    echo "<p>Tidak dapat memverifikasi sesi Anda dengan server SSO.</p>";
    if (isset($data['error'])) {
        echo "<p>Pesan dari server: " . htmlspecialchars($data['error']) . "</p>";
    }
}