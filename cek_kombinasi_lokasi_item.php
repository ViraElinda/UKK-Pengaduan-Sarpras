<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "🔍 Semua pengaduan dengan id_item (bukan NULL):\n";
echo str_repeat("=", 90) . "\n\n";

$stmt = $pdo->query("
    SELECT 
        pengaduan.id_pengaduan,
        pengaduan.nama_pengaduan,
        pengaduan.id_lokasi,
        lokasi.nama_lokasi,
        pengaduan.id_item,
        items.nama_item,
        pengaduan.status,
        pengaduan.tgl_pengajuan
    FROM pengaduan 
    LEFT JOIN lokasi ON lokasi.id_lokasi = pengaduan.id_lokasi
    LEFT JOIN items ON items.id_item = pengaduan.id_item
    WHERE pengaduan.id_item IS NOT NULL
    ORDER BY pengaduan.id_pengaduan DESC
    LIMIT 10
");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$grouped = [];
foreach ($results as $row) {
    $key = $row['id_lokasi'] . '_' . $row['id_item'];
    if (!isset($grouped[$key])) {
        $grouped[$key] = [
            'lokasi' => $row['nama_lokasi'] . " (ID: {$row['id_lokasi']})",
            'item' => $row['nama_item'] . " (ID: {$row['id_item']})",
            'records' => []
        ];
    }
    $grouped[$key]['records'][] = $row;
}

foreach ($grouped as $combo => $data) {
    echo "📍 Lokasi: {$data['lokasi']} | Item: {$data['item']}\n";
    echo str_repeat("-", 90) . "\n";
    
    $hasProses = false;
    foreach ($data['records'] as $rec) {
        $isProses = in_array($rec['status'], ['Diajukan', 'Disetujui', 'Diproses']);
        $icon = $isProses ? '🔴' : '🟢';
        if ($isProses) $hasProses = true;
        
        echo "  $icon ID: {$rec['id_pengaduan']} | Status: {$rec['status']} | {$rec['nama_pengaduan']}\n";
    }
    
    if ($hasProses) {
        echo "  ❌ KOMBINASI INI TIDAK BISA DIGUNAKAN LAGI (ada yang masih proses)\n";
    } else {
        echo "  ✅ KOMBINASI INI BISA DIGUNAKAN (semua sudah selesai/ditolak)\n";
    }
    echo "\n";
}

echo str_repeat("=", 90) . "\n";
echo "💡 Kombinasi yang BISA digunakan ditandai dengan ✅\n";
echo "💡 Kombinasi yang TIDAK BISA digunakan ditandai dengan ❌ (tunggu hingga selesai)\n";
