<?php

$db = new mysqli('localhost', 'root', '', 'pengaduan_sarpras');

echo "🔍 Checking Pengaduan ID 160\n\n";

$result = $db->query("
    SELECT id_pengaduan, nama_pengaduan, status, foto_balasan, saran_petugas, 
           id_petugas, tgl_pengajuan, tgl_selesai
    FROM pengaduan 
    WHERE id_pengaduan = 160
");

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "✅ Pengaduan Found:\n";
    echo "ID: {$row['id_pengaduan']}\n";
    echo "Nama: {$row['nama_pengaduan']}\n";
    echo "Status: {$row['status']}\n";
    echo "ID Petugas: " . ($row['id_petugas'] ?? 'NULL') . "\n";
    echo "Saran Petugas: " . ($row['saran_petugas'] ?? 'NULL') . "\n";
    echo "Foto Balasan: " . ($row['foto_balasan'] ?? 'NULL') . "\n";
    echo "Tgl Pengajuan: {$row['tgl_pengajuan']}\n";
    echo "Tgl Selesai: " . ($row['tgl_selesai'] ?? 'NULL') . "\n";
    
    if (empty($row['foto_balasan'])) {
        echo "\n❌ PROBLEM: foto_balasan is empty in database!\n";
        echo "But files exist in directory:\n";
        $files = glob(__DIR__ . '/public/uploads/foto_balasan/balasan_160_*');
        foreach ($files as $file) {
            $size = filesize($file);
            $time = date('Y-m-d H:i:s', filemtime($file));
            echo "  - " . basename($file) . " (" . round($size/1024, 2) . " KB, modified: $time)\n";
        }
    } else {
        echo "\n✅ foto_balasan set in database: {$row['foto_balasan']}\n";
        $filePath = __DIR__ . '/public/uploads/foto_balasan/' . $row['foto_balasan'];
        if (is_file($filePath)) {
            echo "✅ File exists on disk\n";
        } else {
            echo "❌ File NOT found on disk: $filePath\n";
        }
    }
} else {
    echo "❌ Pengaduan ID 160 not found\n";
}

$db->close();
