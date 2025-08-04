<?php
// Tangkap URL direktori saat ini
$currentDir = dirname($_SERVER['PHP_SELF']);

// Buat path relatif menuju login.php di direktori yang sama
$loginPath = rtrim($currentDir, '/\\') . '/login.php';

// Redirect ke login.php
header("Location: $loginPath");
exit;