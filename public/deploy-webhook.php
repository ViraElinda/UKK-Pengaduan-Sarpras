<?php
// Simple Webhook-based Deployment Script

// 1. Konfigurasi Secret Token
// Ambil dari environment variable atau hardcode di sini.
// JANGAN PERNAH bocorkan token ini.
$secretToken = getenv('DEPLOY_SECRET_TOKEN') ?: 'GANTI-DENGAN-TOKEN-RAHASIA-SUPER-AMAN-ANDA';

// 2. Validasi Request
$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$requestToken = '';
if (preg_match('/^Bearer\s+(.*)$/', $authHeader, $matches)) {
    $requestToken = $matches[1];
}

if ($requestToken !== $secretToken) {
    header('HTTP/1.1 403 Forbidden');
    die('Error: Invalid or missing secret token.');
}

// 3. Jalankan Script Deploy
// Pastikan path ke script shell sudah benar.
$scriptPath = __DIR__ . '/../deploy-from-webhook.sh';
$output = [];
$returnCode = -1;

// Pastikan script bisa dieksekusi
if (!is_executable($scriptPath)) {
    header('HTTP/1.1 500 Internal Server Error');
    die("Error: Deployment script is not executable. Run 'chmod +x {$scriptPath}' on your server.");
}

// Jalankan script dan tangkap outputnya
exec("{$scriptPath} 2>&1", $output, $returnCode);

// 4. Tampilkan Hasil
header('Content-Type: text/plain');
echo "=========================================\n";
echo "🚀 DEPLOYMENT LOGS\n";
echo "=========================================\n\n";
echo implode("\n", $output);
echo "\n\n";
echo "Exit Code: {$returnCode}\n";
echo "✅ Deployment script finished.\n";

?>
