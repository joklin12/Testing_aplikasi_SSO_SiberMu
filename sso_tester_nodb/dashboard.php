<?php
/**
 * @package     Testing SSO Sibermu
 * @author      Joko Supriyanto <joko@sibermu.ac.id>
 * @copyright   Copyright (C) Juni 2025 Biro Sistem Informasi SiberMu. All rights reserved.
 * @license     GPLv3
 */
session_start();

// Cek apakah user sudah login di aplikasi ini
if (!isset($_SESSION['user'])) {
    header('Location: logout.php');
    exit;
}

$user = $_SESSION['user'];

// URL Server SSO Anda
$sso_server_url = 'https://sso.sibermu.ac.id'; // GANTI SESUAI URL ANDA

// Halaman login aplikasi ini, tempat pengguna akan kembali setelah logout
$client_login_page = 'http://localhost/sso_tester_nodb/callback.php'; // GANTI SESUAI URL ANDA (arahkan ke halaman web utama anda setelah logout)

// Buat URL logout terpusat yang lengkap
$logout_url = $sso_server_url . '/logout.php?redirect_uri=' . urlencode($client_login_page);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard E-Learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h1 class="h4 mb-0">✨ Dashboard Testing SSO SiberMu</h1>
            </div>
            <div class="card-body">
                <h5 class="card-title">Selamat Datang, <?php echo htmlspecialchars($user['nama']); ?>!</h5>
                <p class="card-text text-muted">Berikut adalah data Anda yang terverifikasi melalui server SSO.</p>

                <div class="card mt-4">
                    <div class="card-header">
                        Informasi Pengguna
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>ID Unik:</strong>
                            <span><?php echo htmlspecialchars($user['nisn']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>No. HP:</strong>
                            <span><?php echo htmlspecialchars($user['no_hp']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Pekerjaaan:</strong>
                            <span><?php echo htmlspecialchars($user['pekerjaan']); ?></span>
                        </li>	
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Institusi:</strong>
                            <span class="badge bg-success"><?php echo htmlspecialchars($user['institusi']); ?></span>
                        </li>						
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Organisasi:</strong>
                            <span class="badge bg-success"><?php echo htmlspecialchars($user['organisasi']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Alamat:</strong>
                            <span><?php echo htmlspecialchars($user['alamat']); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Role:</strong>
                            <span><?php echo htmlspecialchars($user['role']); ?></span>
                        </li>
                       <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Admin Organisasi:</strong>
                            <span><?php echo htmlspecialchars($user['created_by']); ?></span>
                        </li>						
                    </ul>
                </div>
                
                <div class="text-center mt-4">
				<?php
				// URL Server SSO Anda
				$sso_server_url = 'https://sso.sibermu.ac.id'; // GANTI SESUAI URL ANDA

				// Halaman login aplikasi ini, tempat pengguna akan kembali setelah logout
				$client_login_page = 'http://localhost/sso_tester_nodb/logout.php'; // GANTI SESUAI URL ANDA

				// Buat URL logout terpusat yang lengkap
				$logout_url = $sso_server_url . '/logout.php?redirect_uri=' . urlencode($client_login_page);
				?>
                    <a href="<?php echo $logout_url; ?>" class="btn btn-danger">
                        🚪 Logout
                    </a>
                </div>
            </div>
        </div>

        <footer class="text-center text-muted mt-4">
            <p>SiberMu &copy; <?php echo date("Y"); ?> Testing SSO SiberMu Platform</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>