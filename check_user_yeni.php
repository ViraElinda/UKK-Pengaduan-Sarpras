<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "🔍 Mencari pengaduan user yeni (id 55):\n\n";

$stmt = $pdo->query("SELECT id_pengaduan, nama_pengaduan, foto, foto_balasan, status 
                     FROM pengaduan 
                     WHERE id_user = 55 
                     ORDER BY id_pengaduan DESC 
                     LIMIT 5");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($results)) {
    echo "❌ Tidak ada pengaduan untuk user id 55\n";
    exit;
}

echo "📋 Pengaduan user yeni:\n";
echo str_repeat("=", 80) . "\n";

foreach ($results as $row) {
    echo "ID: {$row['id_pengaduan']}\n";
    echo "Nama: {$row['nama_pengaduan']}\n";
    echo "Foto User: " . ($row['foto'] ?? 'NULL') . "\n";
    echo "Foto Balasan: " . ($row['foto_balasan'] ?? 'NULL') . "\n";
    echo "Status: {$row['status']}\n";
    
    // Check files
    if ($row['foto']) {
        $path = __DIR__ . '/public/uploads/foto_pengaduan/' . $row['foto'];
        echo "  Foto User File: " . (file_exists($path) ? '✅ EXISTS' : '❌ NOT FOUND') . "\n";
    }
    
    if ($row['foto_balasan']) {
        $path = __DIR__ . '/public/uploads/foto_balasan/' . $row['foto_balasan'];
        echo "  Foto Balasan File: " . (file_exists($path) ? '✅ EXISTS' : '❌ NOT FOUND') . "\n";
    }
    
    echo str_repeat("-", 80) . "\n";
}

echo "\n💡 Mencari pengaduan yang SUDAH SELESAI dan PUNYA foto_balasan:\n";
echo str_repeat("=", 80) . "\n";

$stmt = $pdo->query("SELECT id_pengaduan, id_user, nama_pengaduan, foto_balasan, status 
                     FROM pengaduan 
                     WHERE foto_balasan IS NOT NULL 
                     AND foto_balasan != '' 
                     AND status = 'Selesai'
                     LIMIT 5");

$withBalasan = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($withBalasan)) {
    echo "❌ Tidak ada pengaduan dengan foto_balasan yang selesai\n";
} else {
    foreach ($withBalasan as $row) {
        echo "ID: {$row['id_pengaduan']} | User ID: {$row['id_user']} | Foto Balasan: {$row['foto_balasan']}\n";
        
        $path = __DIR__ . '/public/uploads/foto_balasan/' . $row['foto_balasan'];
        if (file_exists($path)) {
            echo "  ✅ File exists (" . number_format(filesize($path)/1024, 2) . " KB)\n";
        } else {
            echo "  ❌ File NOT FOUND\n";
        }
    }
}

echo "\n🔧 Solusi: Petugas perlu upload foto_balasan untuk pengaduan user yeni!\n";
