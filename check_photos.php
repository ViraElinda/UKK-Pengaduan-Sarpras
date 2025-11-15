<?php
$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$stmt = $pdo->query('SELECT id_pengaduan, foto, foto_balasan, status FROM pengaduan WHERE id_pengaduan = 160');
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo "📊 Data Pengaduan ID 160:\n";
echo "========================\n";
echo "Foto User: " . ($row['foto'] ?? 'NULL/KOSONG') . "\n";
echo "Foto Balasan: " . ($row['foto_balasan'] ?? 'NULL/KOSONG') . "\n";
echo "Status: " . $row['status'] . "\n\n";

// Check files
if ($row['foto']) {
    $path1 = __DIR__ . '/public/uploads/foto_pengaduan/' . $row['foto'];
    echo "Cek Foto User:\n";
    echo "  Path: $path1\n";
    echo "  Exists: " . (file_exists($path1) ? '✅ YES' : '❌ NO') . "\n\n";
}

if ($row['foto_balasan']) {
    $path2 = __DIR__ . '/public/uploads/foto_balasan/' . $row['foto_balasan'];
    echo "Cek Foto Balasan:\n";
    echo "  Path: $path2\n";
    echo "  Exists: " . (file_exists($path2) ? '✅ YES' : '❌ NO') . "\n";
}
