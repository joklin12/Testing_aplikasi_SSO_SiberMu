<?php
// =====================================================================
// == KONFIGURASI API (Ubah jika perlu) ==
// =====================================================================
$api_url = 'https://sso.sibermu.ac.id/api_delete_user.php'; //ganti url SSO SiberMu : https://sso.sibermu.ac.id/api_delete_user.php
$api_token = 'token_dari_ sso.sibermu.ac.id';

// Inisialisasi variabel untuk menampilkan pesan
$message = '';
$message_type = ''; // 'success' atau 'error'

// =====================================================================
// == LOGIKA PEMROSESAN FORMULIR (TETAP SAMA) ==
// =====================================================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil NISN dari input form
    $nisn_to_delete = isset($_POST['nisn']) ? trim($_POST['nisn']) : '';

    if (empty($nisn_to_delete)) {
        $message = 'NISN tidak boleh kosong.';
        $message_type = 'error';
    } else {
        // 2. Siapkan data yang akan dikirim dalam format JSON
        $data = [
            'api_token' => $api_token,
            'nisn'      => $nisn_to_delete
        ];
        $payload = json_encode($data);

        // 3. Inisialisasi cURL untuk berkomunikasi dengan API
        $ch = curl_init($api_url);

        // 4. Atur opsi cURL
        $headers = [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ];
        $referer_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_REFERER, $referer_url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // 5. Eksekusi cURL dan tangkap responsnya
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        // 6. Proses respons dari API
        if ($response === false) {
            $message = 'Gagal terhubung ke API server. Error: ' . $curl_error;
            $message_type = 'error';
        } else {
            $result = json_decode($response, true);

            if ($http_code == 200 && isset($result['success']) && $result['success']) {
                $message = $result['message']; // Akan menampilkan pesan "berhasil diarsipkan dan dihapus" dari API
                $message_type = 'success';
            } else {
                $message = isset($result['error']) ? $result['error'] : 'Terjadi kesalahan yang tidak diketahui.';
                $message_type = 'error';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsipkan Pengguna SSO</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 30px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            /* Diubah: Warna tombol dari merah ke biru */
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            /* Diubah: Warna hover disesuaikan */
            background-color: #0056b3;
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: 500;
            display: <?php echo empty($message) ? 'none' : 'block'; ?>;
        }
        .message.success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }
        .message.error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Arsipkan Pengguna</h2>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="nisn">Masukkan NISN Pengguna yang akan diarsipkan:</label>
                <input type="text" id="nisn" name="nisn" placeholder="Contoh: 1234567890" required>
            </div>
            <button type="submit">Arsipkan dan Hapus Pengguna</button>
        </form>
    </div>
</body>
</html>