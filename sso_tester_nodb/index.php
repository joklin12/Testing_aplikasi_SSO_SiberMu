<?php
/**
 * @package     Testing SSO Sibermu
 * @author      Joko Supriyanto <joko@sibermu.ac.id>
 * @copyright   Copyright (C) Juni 2025 Biro Sistem Informasi SiberMu. All rights reserved.
 * @license     GPLv3
 */
session_start();

// Jika sudah ada sesi user, langsung arahkan ke dashboard
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

// --- KONFIGURASI APLIKASI KLIEN ---
$sso_server_url = 'https://sso.sibermu.ac.id'; // Ganti dengan URL SSO Server Anda
$my_app_api_token = 'd48fb3b381d0b9f576129e9dae8dd3d9654826aa95099d06c0bbd4f5f09fa33d'; // Token dari aplikasi SSO SiberMu
$callback_url = 'http://localhost/sso_tester_nodb/callback.php'; // GANTI SESUAI URL APLIKASI ANDA

// URL untuk otentikasi SSO
$auth_url = $sso_server_url . '/auth.php?redirect_uri=' . urlencode($callback_url) . '&token=' . $my_app_api_token;

// Menyiapkan pesan error untuk ditampilkan
$errorMessage = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'org_mismatch') {
        $errorMessage = 'Login ditolak. Organisasi Anda tidak diizinkan mengakses aplikasi ini.';
    } elseif ($_GET['error'] === 'auth_failed') {
        $errorMessage = 'Proses otentikasi gagal atau dibatalkan. Silakan coba lagi.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login E-Learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            width: 100%;
            max-width: 450px;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .login-card .card-body { padding: 3rem; }
        .login-card .brand-logo { font-size: 3rem; color: #764ba2; }
        .btn-login {
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            background-color: #667eea;
            border-color: #667eea;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #5a6fd9;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="card login-card">
        <div class="card-body text-center">
            <div class="mb-4">
                <span class="brand-logo">🎓</span>
                <h2 class="h4 mt-2 fw-bold">Tes SSO SiberMu no "DB"</h2>
                <p class="text-muted">login page menggunakan index.php</p>
				<p class="text-muted">user : testing2025 pass : 123456 </p>
            </div>

            <?php if ($errorMessage): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <div class="d-grid" id="sso-button-container">
                
            </div>

            <div class="mt-4">
                <small class="text-muted">SiberMu &copy; <?php echo date("Y"); ?> All Rights Reserved.</small>
            </div>
        </div>
    </div>

    <script>
        // Jalankan skrip setelah seluruh halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            
            // Ambil variabel dari PHP
            const ssoServerUrl = '<?php echo $sso_server_url; ?>';
            const apiClientToken = '<?php echo $my_app_api_token; ?>';
            const clientCallbackUrl = '<?php echo $callback_url; ?>';
            const authUrl = '<?php echo htmlspecialchars($auth_url); ?>';

            // URL endpoint pengecekan status di server SSO
            const statusCheckUrl = `${ssoServerUrl}/check_status.php?token=${apiClientToken}&client_url=${encodeURIComponent(clientCallbackUrl)}`;
            
            // Ambil elemen kontainer tombol
            const ssoContainer = document.getElementById('sso-button-container');

            // Panggil endpoint menggunakan Fetch API
            fetch(statusCheckUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Cek status dari response JSON
                    if (data.status === 'active') {
                        // Jika aktif, tampilkan tombol login
                        ssoContainer.innerHTML = `<a href="${authUrl}" class="btn btn-primary btn-login">🔑 Login with SSO</a>`;
                    } else {
                        // Jika tidak aktif, tampilkan pesan jikalau diperlukan
                        
                    }
                })
                .catch(error => {
                    // Tangani jika terjadi error koneksi atau lainnya
                    console.error('Error fetching SSO status:', error);
                    ssoContainer.innerHTML = '<p class="alert alert-danger">Gagal terhubung ke server SSO. Silakan coba lagi nanti.</p>';
                });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>