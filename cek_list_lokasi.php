<?php

$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "🔍 Cek tabel list_lokasi:\n";
echo str_repeat("=", 80) . "\n\n";

$stmt = $pdo->query("SELECT COUNT(*) as total FROM list_lokasi");
$count = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Total relasi: {$count['total']}\n\n";

if ($count['total'] == 0) {
    echo "⚠️ Tabel list_lokasi KOSONG!\n";
    echo "💡 Items tidak akan muncul berdasarkan lokasi karena tidak ada relasi!\n\n";
    
    echo "📊 Lokasi tersedia:\n";
    $stmt = $pdo->query("SELECT * FROM lokasi LIMIT 5");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "  - ID: {$row['id_lokasi']} | {$row['nama_lokasi']}\n";
    }
    
    echo "\n📊 Items tersedia:\n";
    $stmt = $pdo->query("SELECT * FROM items LIMIT 10");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "  - ID: {$row['id_item']} | {$row['nama_item']}\n";
    }
    
    echo "\n🔧 SOLUSI: Isi tabel list_lokasi untuk menghubungkan lokasi dengan items!\n";
    echo "   Contoh: INSERT INTO list_lokasi (id_lokasi, id_item) VALUES (1, 28);\n";
    
} else {
    echo "✅ Tabel list_lokasi terisi!\n\n";
    
    echo "📋 Relasi Lokasi-Item:\n";
    echo str_repeat("-", 80) . "\n";
    
    $stmt = $pdo->query("
        SELECT 
            list_lokasi.id_lokasi,
            lokasi.nama_lokasi,
            list_lokasi.id_item,
            items.nama_item
        FROM list_lokasi
        LEFT JOIN lokasi ON lokasi.id_lokasi = list_lokasi.id_lokasi
        LEFT JOIN items ON items.id_item = list_lokasi.id_item
        ORDER BY list_lokasi.id_lokasi, items.nama_item
        LIMIT 20
    ");
    
    $currentLokasi = null;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($currentLokasi !== $row['id_lokasi']) {
            $currentLokasi = $row['id_lokasi'];
            echo "\n📍 {$row['nama_lokasi']} (ID: {$row['id_lokasi']}):\n";
        }
        echo "   🔧 {$row['nama_item']} (ID: {$row['id_item']})\n";
    }
}
