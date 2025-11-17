<?php

/**
 * TEMPORARY FIX: Disable Cache
 * 
 * Jika permission writable tidak bisa diubah,
 * gunakan script ini untuk disable cache sementara
 * 
 * Upload ke root directory, lalu akses via browser
 */

define('FIX_PASSWORD', 'pengaduan2024');

if (!isset($_GET['pass']) || $_GET['pass'] !== FIX_PASSWORD) {
    die('❌ Akses ditolak! Tambahkan ?pass=pengaduan2024 di URL');
}

echo "<h2>🔧 Temporary Fix: Disable Cache</h2>";
echo "<hr>";

$configFile = __DIR__ . '/app/Config/Cache.php';

if (!file_exists($configFile)) {
    die("❌ File Config/Cache.php tidak ditemukan!");
}

// Backup original
$backupFile = __DIR__ . '/app/Config/Cache.php.backup';
if (!file_exists($backupFile)) {
    if (copy($configFile, $backupFile)) {
        echo "✅ Backup created: app/Config/Cache.php.backup<br>";
    }
}

// Read file
$content = file_get_contents($configFile);

// Replace handler
$content = preg_replace(
    "/public string \\\$handler = 'file';/",
    "public string \$handler = 'dummy';",
    $content
);

// Write back
if (file_put_contents($configFile, $content)) {
    echo "✅ Cache handler changed to 'dummy'<br>";
    echo "<br>";
    echo "<h3>✅ Cache Disabled!</h3>";
    echo "<p>Sekarang website Anda bisa diakses tanpa error cache.</p>";
    echo "<p><strong>Note:</strong> Performa mungkin sedikit lebih lambat karena cache disabled.</p>";
    echo "<br>";
    echo "<p><strong>Untuk restore cache:</strong></p>";
    echo "<ol>";
    echo "<li>Fix permission folder writable (chmod 777)</li>";
    echo "<li>Copy app/Config/Cache.php.backup ke app/Config/Cache.php</li>";
    echo "</ol>";
} else {
    echo "❌ Gagal menulis file. Coba manual edit app/Config/Cache.php<br>";
    echo "<p>Ubah baris:</p>";
    echo "<code>public string \$handler = 'file';</code><br>";
    echo "<p>Menjadi:</p>";
    echo "<code>public string \$handler = 'dummy';</code>";
}

echo "<br><hr>";
echo "<p><strong>⚠️ HAPUS file ini setelah selesai!</strong></p>";
?>
