<?php

require_once __DIR__ . '/vendor/autoload.php';

$db = \Config\Database::connect();

echo "🔍 Test getItems untuk lokasi ID 1:\n";
echo str_repeat("=", 70) . "\n\n";

// Simulate what the controller does
$result = $db->table('list_lokasi')
    ->select('items.id_item, items.nama_item')
    ->join('items', 'items.id_item = list_lokasi.id_item', 'left')
    ->where('list_lokasi.id_lokasi', 1)
    ->get()
    ->getResultArray();

if (empty($result)) {
    echo "❌ Tidak ada items untuk lokasi ID 1\n";
    echo "💡 Perlu mengisi tabel list_lokasi!\n\n";
    
    // Check lokasi dan items
    echo "📊 Lokasi tersedia:\n";
    $lokasi = $db->table('lokasi')->get()->getResultArray();
    foreach ($lokasi as $lok) {
        echo "  - ID: {$lok['id_lokasi']} | {$lok['nama_lokasi']}\n";
    }
    
    echo "\n📊 Items tersedia:\n";
    $items = $db->table('items')->limit(10)->get()->getResultArray();
    foreach ($items as $item) {
        echo "  - ID: {$item['id_item']} | {$item['nama_item']}\n";
    }
    
    echo "\n💡 Tabel list_lokasi menghubungkan lokasi dengan items!\n";
    
} else {
    echo "✅ Items ditemukan untuk lokasi ID 1:\n\n";
    foreach ($result as $item) {
        echo "  - ID: {$item['id_item']} | {$item['nama_item']}\n";
    }
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "🔧 Cek tabel list_lokasi:\n\n";

$listLokasi = $db->table('list_lokasi')
    ->select('list_lokasi.*, lokasi.nama_lokasi, items.nama_item')
    ->join('lokasi', 'lokasi.id_lokasi = list_lokasi.id_lokasi', 'left')
    ->join('items', 'items.id_item = list_lokasi.id_item', 'left')
    ->limit(10)
    ->get()
    ->getResultArray();

if (empty($listLokasi)) {
    echo "⚠️ Tabel list_lokasi KOSONG!\n";
    echo "💡 Perlu mengisi data relasi lokasi-item!\n";
} else {
    echo "Relasi Lokasi-Item yang tersedia:\n\n";
    foreach ($listLokasi as $row) {
        echo "  📍 {$row['nama_lokasi']} → 🔧 {$row['nama_item']}\n";
    }
}
