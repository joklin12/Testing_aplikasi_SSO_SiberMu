<?php
/**
 * @package     Testing SSO Sibermu with database
 * @author      Joko Supriyanto <joko@sibermu.ac.id>
 * @copyright   Copyright (C) Juni 2025 Biro Sistem Informasi SiberMu. All rights reserved.
 * @license     GPLv3
 */

// --- GANTI SESUAI KONFIGURASI DATABASE ANDA ---
$db_host = 'localhost';     // Biasanya 'localhost'
$db_user = 'root';          // User database Anda
$db_pass = '';              // Password database Anda
$db_name = 'user_tes_sso_sibermu';      // Nama database Anda
// ---------------------------------------------

// Membuat koneksi ke database menggunakan MySQLi
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Memeriksa apakah koneksi gagal
if ($mysqli->connect_error) {
    // Hentikan eksekusi dan tampilkan pesan error jika koneksi gagal
    die('Koneksi Database Gagal: ' . $mysqli->connect_error);
}

// Set charset ke utf8mb4 untuk mendukung karakter yang lebih luas
$mysqli->set_charset('utf8mb4');