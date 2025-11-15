<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "📋 Semua pengaduan yang punya foto_balasan:\n\n";

$stmt = $pdo->query("SELECT id_pengaduan, status, foto_balasan FROM pengaduan WHERE foto_balasan IS NOT NULL AND foto_balasan != ''");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($results)) {
    echo "❌ Tidak ada pengaduan dengan foto_balasan\n";
} else {
    foreach ($results as $row) {
        echo "ID: {$row['id_pengaduan']} | Status: {$row['status']} | Foto: {$row['foto_balasan']}\n";
        
        // Check file
        $path = __DIR__ . '/public/uploads/foto_balasan/' . $row['foto_balasan'];
        if (file_exists($path)) {
            echo "   ✅ File EXISTS (" . number_format(filesize($path)/1024, 2) . " KB)\n";
        } else {
            echo "   ❌ File NOT FOUND at: $path\n";
        }
        echo "\n";
    }
}
