<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Update dengan file yang BENAR-BENAR ada
$sql = "UPDATE pengaduan SET foto_balasan = ? WHERE id_pengaduan = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute(['balasan_160_1762590086.jpeg', 160]);

echo "✅ Database updated!\n";
echo "📁 Foto balasan: balasan_160_1762590086.jpeg\n\n";

// Verify
$sql = "SELECT id_pengaduan, foto_balasan FROM pengaduan WHERE id_pengaduan = 160";
$result = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

echo "🔍 Database sekarang: " . $result['foto_balasan'] . "\n";

// Check file
$path = __DIR__ . '/public/uploads/foto_balasan/' . $result['foto_balasan'];
if (file_exists($path)) {
    echo "✅ File EXISTS di: $path\n";
    echo "📊 Size: " . number_format(filesize($path) / 1024, 2) . " KB\n";
} else {
    echo "❌ File TIDAK ADA di: $path\n";
}

echo "\n🔄 Refresh browser sekarang!\n";
