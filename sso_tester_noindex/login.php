<?php
session_start();

// Jika sudah ada sesi user, langsung arahkan ke dashboard
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

// Konfigurasi URL
$sso_server_url = 'https://sso.sibermu.ac.id'; // SSO Url SiberMu
$my_app_api_token = 'd48fb3b381d0b9f576129e9dae8dd3d9654826aa95099d06c0bbd4f5f09fa33d'; // token dari aplikasi SSO SiberMu

$callback_url = 'http://localhost/sso_tester_noindex/callback.php'; // GANTI SESUAI URL APLIKASI ANDA 
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
    <title>Login Testing Aplikasi SSO SIberMu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        .login-card .card-body {
            padding: 3rem;
        }
        .login-card .brand-logo {
            font-size: 3rem;
            color: #764ba2;
        }
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
                <h2 class="h4 mt-2 fw-bold">Tes SSO SiberMu <br>No DB & Index</h2>
                <p class="text-muted">Aplikasi ini login page tidak menggunakan index.php melainkan menggunakan login.php</p>
				<p class="text-muted">user : testing2025 | password : 123456 </p>
            </div>

            <?php if ($errorMessage): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <div class="d-grid">
                 <a href="<?php echo htmlspecialchars($auth_url); ?>" class="btn btn-primary btn-login">
                    🔑 Login with SSO
                </a>
            </div>

            <div class="mt-4">
                <small class="text-muted">&copy; <?php echo date("Y"); ?> All Rights Reserved.</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>