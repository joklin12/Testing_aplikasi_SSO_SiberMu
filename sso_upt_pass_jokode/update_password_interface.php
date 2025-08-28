<?php
// =====================================================================
// == 1. KONFIGURASI API DAN DATA PENGGUNA ==
// !! EDIT DATA DI BAWAH INI UNTUK MENGGANTI TARGET PENGGUNA !!
// =====================================================================
date_default_timezone_set('Asia/Jakarta');
$api_url        = 'https://sso.jokode.my.id/api_update_password.php'; //jika server mengunakan SSO Sibermu harus https://sso.sibermu.ac.id/api_update_password.php
$api_token      = 'd48fb3b381d0b9f576129e9dae8dd3d9654826aa95099d06c0bbd4f5f09fa33d'; //Token SSO yang didapat dari sso.sibermu.ac.id

$nisn_to_update = 'skl-011'; // Ganti dengan NISN atau ID Unik pengguna yang dituju
$new_password   = 'ma2154';   // Ganti dengan password baru yang diinginkan

// =====================================================================
// == 2. PROSES PANGGILAN API (Tidak Perlu Diubah) ==
// =====================================================================
$log_output = [];

// Siapkan data yang akan dikirim ke API
$data_to_send = [
    'api_token'    => $api_token,
    'nisn'         => $nisn_to_update,
    'new_password' => $new_password
];
$payload = json_encode($data_to_send);

// Tambahkan detail ke log
$log_output['Waktu Eksekusi']  = date('Y-m-d H:i:s T');
$log_output['Request Payload'] = json_encode($data_to_send, JSON_PRETTY_PRINT);

// Inisialisasi cURL
$ch = curl_init($api_url);
$referer_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ($_SERVER['REQUEST_URI'] ?? '/');

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json', 'Content-Length: ' . strlen($payload)],
    CURLOPT_REFERER        => $referer_url,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_SSL_VERIFYPEER => false,
]);

// Eksekusi cURL dan kumpulkan info
$response    = curl_exec($ch);
$http_code   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error  = curl_error($ch);
curl_close($ch);

// Tambahkan hasil eksekusi ke log
$log_output['HTTP Status Code'] = $http_code;
$log_output['Raw Response']     = $response;
$log_output['cURL Error']       = $curl_error ?: 'Tidak ada';

// Proses respons untuk ringkasan
$summary_message = '';
$summary_type = 'error'; // Default ke error
if ($curl_error) {
    $summary_message = 'Gagal terhubung ke server API.';
} else {
    $result = json_decode($response, true);
    if ($http_code == 200 && isset($result['success']) && $result['success']) {
        $summary_message = $result['message'];
        $summary_type = 'success';
    } else {
        $error_from_api = isset($result['error']) ? $result['error'] : 'Pesan error tidak ditemukan di respons.';
        $summary_message = "[Error Code: {$http_code}] " . $error_from_api;
    }
}
$log_output['Ringkasan Hasil'] = $summary_message;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Proses Update Password</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f7f9; margin: 0; padding: 20px; }
        .wrapper { max-width: 800px; margin: 20px auto; }
        .log-container { background-color: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); }
        h2 { margin-top: 0; margin-bottom: 25px; color: #333; text-align: center; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        .log-item { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #555; font-weight: 600; font-size: 16px; }
        pre { background-color: #e9ecef; padding: 15px; border-radius: 5px; white-space: pre-wrap; word-wrap: break-word; font-family: "SF Mono", "Consolas", "Menlo", monospace; font-size: 14px; margin: 0; }
        .summary { padding: 15px; border-radius: 5px; font-weight: 500; }
        .summary.success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .summary.error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="log-container">
            <h2>Tampilan Log Proses Update Password</h2>
            
            <div class="log-item">
                <label>Ringkasan Hasil:</label>
                <div class="summary <?php echo $summary_type; ?>">
                    <?php echo htmlspecialchars($log_output['Ringkasan Hasil']); ?>
                </div>
            </div>

            <?php foreach ($log_output as $key => $value): ?>
                <?php if ($key === 'Ringkasan Hasil') continue; // Lewati karena sudah ditampilkan di atas ?>
                <div class="log-item">
                    <label><?php echo htmlspecialchars($key); ?>:</label>
                    <pre><?php echo htmlspecialchars($value); ?></pre>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>