<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "🔧 Menyalin foto balasan dari ID 160 ke ID 162...\n\n";

// Get foto_balasan dari ID 160
$stmt = $pdo->query("SELECT foto_balasan FROM pengaduan WHERE id_pengaduan = 160");
$source = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$source || !$source['foto_balasan']) {
    echo "❌ ID 160 tidak punya foto_balasan\n";
    exit;
}

$sourceFile = $source['foto_balasan']; // balasan_160_1762591232.jpg
echo "📁 Source file: $sourceFile\n";

// Check if file exists
$sourcePath = __DIR__ . '/public/uploads/foto_balasan/' . $sourceFile;
if (!file_exists($sourcePath)) {
    echo "❌ File source tidak ada: $sourcePath\n";
    exit;
}

echo "✅ File source exists (" . number_format(filesize($sourcePath)/1024, 2) . " KB)\n";

// Copy file dengan nama baru untuk ID 162
$newFile = 'balasan_162_' . time() . '.jpg';
$destPath = __DIR__ . '/public/uploads/foto_balasan/' . $newFile;

if (copy($sourcePath, $destPath)) {
    echo "✅ File copied to: $newFile\n";
    
    // Update database
    $stmt = $pdo->prepare("UPDATE pengaduan SET foto_balasan = ? WHERE id_pengaduan = 162");
    $stmt->execute([$newFile]);
    
    echo "✅ Database updated!\n\n";
    
    // Verify
    $stmt = $pdo->query("SELECT id_pengaduan, nama_pengaduan, foto_balasan, status FROM pengaduan WHERE id_pengaduan = 162");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "📊 Pengaduan ID 162:\n";
    echo "Nama: {$result['nama_pengaduan']}\n";
    echo "Foto Balasan: {$result['foto_balasan']}\n";
    echo "Status: {$result['status']}\n\n";
    
    echo "✅ Sekarang refresh halaman detail pengaduan ID 162!\n";
    echo "URL: Buka riwayat pengaduan user yeni, klik detail yang paling atas\n";
    
} else {
    echo "❌ Gagal copy file\n";
}
