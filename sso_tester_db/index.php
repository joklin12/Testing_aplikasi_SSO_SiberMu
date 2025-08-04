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

// Konfigurasi URL
$sso_server_url = 'https://sso.sibermu.ac.id'; // SSO Url SiberMu
$my_app_api_token = 'd48fb3b381d0b9f576129e9dae8dd3d9654826aa95099d06c0bbd4f5f09fa33d'; // token dari aplikasi SSO SiberMu
$callback_url = 'http://localhost/sso_tester_db/callback.php'; // GANTI SESUAI URL APLIKASI ANDA 
$auth_url = $sso_server_url . '/auth.php?redirect_uri=' . urlencode($callback_url) . '&token=' . $my_app_api_token;

// Menyiapkan pesan error untuk ditampilkan
$errorMessage = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'org_mismatch') {
        $errorMessage = 'Login ditolak. Institusi/Organisasi Anda tidak diizinkan mengakses aplikasi ini.';
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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 2rem;
        }

        /* The Glassmorphism Card */
        .login-card {
            width: 100%;
            max-width: 480px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            color: white;
        }

        .login-card .card-body {
            padding: 4rem;
        }

        .brand-logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 2rem auto;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .brand-logo .bi {
            font-size: 3.5rem;
            color: #fff;
        }

        .card-title {
            font-weight: 600;
            font-size: 2rem;
        }

        .card-text {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0.5rem;
        }
        
        /* Custom Alert Style */
        .alert-custom {
            background-color: rgba(255, 82, 82, 0.2);
            border: 1px solid rgba(255, 82, 82, 0.4);
            color: white;
            border-radius: 0.75rem;
            padding: 1rem;
        }

        .btn-login {
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 50px;
            background-color: #ffffff;
            color: #667eea;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-login:hover {
            background-color: #f0f2f5;
            color: #5a6fd9;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-top: 2rem;
        }

        @media (max-width: 576px) {
            .login-card .card-body {
                padding: 2.5rem;
            }
            .card-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>

    <div class="card login-card">
        <div class="card-body text-center">
            
            <div class="brand-logo">
                <i class="bi bi-shield-check"></i>
            </div>
            
            <h1 class="card-title">SSO SiberMu dgn Database</h1>
            <p class="card-text">login page menggunakan index.php </p>
			<p class="card-text">user : testing2025 | pass : 123456 </p>

            <?php if ($errorMessage): ?>
                <div class="alert alert-custom mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <div class="d-grid mt-4">
                 <a href="<?php echo htmlspecialchars($auth_url); ?>" class="btn btn-login">
                    Login with SSO <i class="bi bi-box-arrow-in-right ms-2"></i>
                </a>
            </div>

            <div class="footer-text">
                SiberMu &copy; <?php echo date("Y"); ?> All Rights Reserved.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>