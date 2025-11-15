<?php
$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$pdo->exec("UPDATE pengaduan SET foto_balasan = 'balasan_160_1762590622.jpg' WHERE id_pengaduan = 160");
echo "✅ Updated to: balasan_160_1762590622.jpg\n";

// Verify
$result = $pdo->query("SELECT foto_balasan FROM pengaduan WHERE id_pengaduan = 160")->fetch();
echo "📁 Database: " . $result['foto_balasan'] . "\n";

// Check file
$path = __DIR__ . '/public/uploads/foto_balasan/' . $result['foto_balasan'];
if (file_exists($path)) {
    echo "✅ File EXISTS: " . number_format(filesize($path)/1024, 2) . " KB\n";
} else {
    echo "❌ File NOT FOUND\n";
}
