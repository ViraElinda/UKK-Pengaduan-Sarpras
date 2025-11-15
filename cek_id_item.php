<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "🔍 Cek 5 pengaduan terbaru:\n";
echo str_repeat("=", 80) . "\n\n";

$stmt = $pdo->query("
    SELECT 
        id_pengaduan, 
        nama_pengaduan, 
        id_lokasi, 
        id_item, 
        id_temporary,
        status,
        tgl_pengajuan
    FROM pengaduan 
    ORDER BY id_pengaduan DESC 
    LIMIT 5
");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $row) {
    echo "ID: {$row['id_pengaduan']}\n";
    echo "Nama: {$row['nama_pengaduan']}\n";
    echo "id_lokasi: " . ($row['id_lokasi'] ?? 'NULL') . "\n";
    echo "id_item: " . ($row['id_item'] ?? 'NULL') . "\n";
    echo "id_temporary: " . ($row['id_temporary'] ?? 'NULL') . "\n";
    echo "Status: {$row['status']}\n";
    echo "Tanggal: {$row['tgl_pengajuan']}\n";
    echo str_repeat("-", 80) . "\n\n";
}

echo "💡 Sekarang coba buat pengaduan baru dari user dan cek lagi!\n";
