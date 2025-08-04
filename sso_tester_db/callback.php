<?php
/**
 * @package     Testing SSO Sibermu with database
 * @author      Joko Supriyanto <joko@sibermu.ac.id>
 * @copyright   Copyright (C) Juni 2025 Biro Sistem Informasi SiberMu. All rights reserved.
 * @license     GPLv3
 */
 
session_start();

// Memasukkan file koneksi database
require_once 'db.php';

$code = $_GET['code'] ?? null;

if (empty($code)) {
    header('Location: index.php?error=auth_failed');
    exit;
}

$sso_server_url = 'https://sso.sibermu.ac.id';
$verify_url = $sso_server_url . '/api/verify_code.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $verify_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['code' => $code]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);

if ($http_code === 200 && isset($data['success']) && $data['success']) {
    $user_data = $data['user'];

    $allowed = 'SMA 1 TESTING'; 

    if (isset($user_data['institusi']) && $user_data['institusi'] === $allowed) { // untuk ambil organisasi cukup ganti {institusi} ke [organisasi]
        
        // --- LOGIKA DATABASE DIMULAI ---
        
        // Ambil ID Unik (nisn) dari data SSO
        $nisn = $user_data['nisn'];

        // 1. Cek apakah user dengan NISN ini sudah ada di database
        $stmt_check = $mysqli->prepare("SELECT nisn FROM users WHERE nisn = ?");
        $stmt_check->bind_param("s", $nisn);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        // 2. Jika tidak ditemukan (hasil query = 0 baris), maka masukkan data baru
        if ($result->num_rows === 0) {
            // Siapkan statement INSERT untuk mencegah SQL Injection
            $stmt_insert = $mysqli->prepare(
                "INSERT INTO users (nisn, nama, no_hp, pekerjaan, organisasi, institusi, alamat, role, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)"
            );
            
            // Bind parameter ke statement
            $stmt_insert->bind_param(
                "sssssssss",
                $user_data['nisn'],
                $user_data['nama'],
                $user_data['no_hp'],
                $user_data['pekerjaan'],
				$user_data['institusi'],
                $user_data['organisasi'],
                $user_data['alamat'],
                $user_data['role'],
                $user_data['created_by']
            );
            
            // Eksekusi statement untuk menyimpan data
            $stmt_insert->execute();
            $stmt_insert->close();
        }
        // Jika user sudah ada, tidak ada tindakan yang dilakukan.

        $stmt_check->close();
        // --- LOGIKA DATABASE SELESAI ---

        // Simpan data user ke session dan lanjutkan ke dashboard
        $_SESSION['user'] = $user_data;
        header('Location: dashboard.php');
        exit;

    } else {
        session_unset();
        session_destroy();
        header('Location: index.php?error=org_mismatch');
        exit;
    }
} else {
    echo "<h1>Login Gagal!</h1>";
    echo "<p>Tidak dapat memverifikasi sesi Anda dengan server SSO.</p>";
    if (isset($data['error'])) {
        echo "<p>Pesan dari server: " . htmlspecialchars($data['error']) . "</p>";
    }
}