<?php

require_once __DIR__ . '/vendor/autoload.php';

$db = \Config\Database::connect();

echo "🔍 Test Query Model (sama persis dengan controller)\n";
echo "=" . str_repeat("=", 60) . "\n\n";

$result = $db->table('pengaduan')
    ->select('pengaduan.*, lokasi.nama_lokasi, items.nama_item')
    ->join('lokasi', 'lokasi.id_lokasi = pengaduan.id_lokasi', 'left')
    ->join('items', 'items.id_item = pengaduan.id_item', 'left')
    ->where('pengaduan.id_pengaduan', 160)
    ->get()
    ->getRowArray();

if (!$result) {
    echo "❌ Data tidak ditemukan!\n";
    exit;
}

echo "✅ Data ditemukan!\n\n";
echo "ID: " . $result['id_pengaduan'] . "\n";
echo "Nama Pengaduan: " . $result['nama_pengaduan'] . "\n";
echo "Foto User: " . ($result['foto'] ?? 'NULL') . "\n";
echo "Foto Balasan: " . ($result['foto_balasan'] ?? 'NULL') . "\n";
echo "Status: " . $result['status'] . "\n\n";

echo "📋 Semua Keys:\n";
$keys = array_keys($result);
foreach ($keys as $key) {
    echo "  - $key\n";
}

// Check if foto_balasan column exists
if (array_key_exists('foto_balasan', $result)) {
    echo "\n✅ Column 'foto_balasan' EXISTS in result\n";
    if (!empty($result['foto_balasan'])) {
        echo "✅ foto_balasan HAS VALUE: " . $result['foto_balasan'] . "\n";
    } else {
        echo "⚠️  foto_balasan is EMPTY or NULL\n";
    }
} else {
    echo "\n❌ Column 'foto_balasan' NOT FOUND in result!\n";
}
