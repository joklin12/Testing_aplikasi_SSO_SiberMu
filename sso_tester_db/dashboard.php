<?php
/**
 * @package     Testing SSO Sibermu with database
 * @author      Joko Supriyanto <joko@sibermu.ac.id>
 * @copyright   Copyright (C) Juni 2025 Biro Sistem Informasi SiberMu. All rights reserved.
 * @license     GPLv3
 */
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    header('Location: logout.php');
    exit;
}

$user = $_SESSION['user'];

// Konfigurasi Logout
$sso_server_url = 'https://sso.sibermu.ac.id'; 
$client_logout_handler = 'http://localhost/sso_tester_db/logout.php'; // Ganti sesuai URL Anda
$logout_url = $sso_server_url . '/logout.php?redirect_uri=' . urlencode($client_logout_handler);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - <?php echo htmlspecialchars($user['nama']); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-light: #f7f9fc;
            --card-bg: #ffffff;
            --text-dark: #343a40;
            --text-secondary: #6c757d;
            --accent-color: #20c997; /* Teal / Mint Green */
            --border-color: #e9ecef;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .dashboard-card {
            background-color: var(--card-bg);
            border-radius: 24px;
            border: none;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.07);
            width: 100%;
            max-width: 750px;
            overflow: hidden;
        }

        .dashboard-header {
            padding: 2.5rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .profile-icon-wrapper {
            flex-shrink: 0;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-color), #28a745);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            box-shadow: 0 4px 15px rgba(32, 201, 151, 0.4);
        }
        
        .user-title h1 {
            font-weight: 600;
            font-size: 2rem;
            margin: 0;
            line-height: 1.2;
        }
        
        .user-title p {
            font-weight: 400;
            color: var(--text-secondary);
            margin: 0;
            font-size: 1rem;
        }

        .info-list .list-group-item {
            background: transparent;
            border: none;
            border-top: 1px solid var(--border-color);
            padding: 1.25rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .info-list .list-group-item:first-child {
            border-top: none;
        }

        .info-label {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            color: var(--text-secondary);
        }
        
        .info-label .icon {
            font-size: 1.3rem;
            color: var(--accent-color);
        }

        .info-value {
            font-weight: 500;
            text-align: right;
        }

        .card-footer {
            background-color: var(--bg-light);
            padding: 1.5rem 2.5rem;
        }

        .logout-btn {
            background-color: var(--accent-color);
            border: none;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(32, 201, 151, 0.3);
        }
    </style>
</head>
<body>
    
    <div class="dashboard-card">
        <div class="dashboard-header">
            <div class="profile-icon-wrapper">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="user-title">
                <h1><?php echo htmlspecialchars($user['nama']); ?></h1>
                <p>Selamat Datang di Dasbor Anda <br> cek di database, seharusnya nama tersebut sudah tersimpan di database anda</p>
            </div>
        </div>
        
        <div class="card-body p-0">
            <ul class="list-group list-group-flush info-list">
                <li class="list-group-item">
                    <span class="info-label"><i class="bi bi-shield-check-fill icon"></i>Organisasi</span>
                    <span class="info-value badge bg-success-subtle text-success-emphasis rounded-pill fs-6 fw-normal"><?php echo htmlspecialchars($user['organisasi']); ?></span>
                </li>
                <li class="list-group-item">
                    <span class="info-label"><i class="bi bi-shield-check-fill icon"></i>Institusi</span>
                    <span class="info-value badge bg-success-subtle text-success-emphasis rounded-pill fs-6 fw-normal"><?php echo htmlspecialchars($user['institusi']); ?></span>
                </li>				
                <li class="list-group-item">
                    <span class="info-label"><i class="bi bi-fingerprint icon"></i>ID Unik (NISN)</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['nisn']); ?></span>
                </li>
                <li class="list-group-item">
                    <span class="info-label"><i class="bi bi-briefcase-fill icon"></i>Pekerjaan</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['pekerjaan']); ?></span>
                </li>
                <li class="list-group-item">
                    <span class="info-label"><i class="bi bi-telephone-fill icon"></i>Nomor HP</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['no_hp']); ?></span>
                </li>
                <li class="list-group-item">
                    <span class="info-label"><i class="bi bi-person-rolodex icon"></i>Role</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['role']); ?></span>
                </li>
				
                <li class="list-group-item">
                    <span class="info-label"><i class="bi bi-person-video3 icon"></i>Admin Organisasi</span>
                    <span class="info-value"><?php echo htmlspecialchars($user['created_by']); ?></span>
                </li>
            </ul>
        </div>

        <div class="card-footer text-center">
             <a href="<?php echo $logout_url; ?>" class="btn btn-primary logout-btn">
                <i class="bi bi-box-arrow-right me-2"></i>Keluar
            </a>
        </div>
    </div>

</body>
</html>