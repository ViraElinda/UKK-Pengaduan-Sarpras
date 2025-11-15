<?php
require_once 'preload.php';

// Test insert temporary item langsung
$db = \Config\Database::connect();

echo "🧪 Test Insert Temporary Item\n";
echo "=" . str_repeat("=", 40) . "\n\n";

try {
    // Data test
    $testData = [
        'nama_barang_baru'   => 'Test Item Manual - ' . date('H:i:s'),
        'lokasi_barang_baru' => 'Test Lokasi',
        'status'             => 'pending'
    ];
    
    echo "📝 Data yang akan diinsert:\n";
    print_r($testData);
    echo "\n";
    
    // Insert
    $result = $db->table('temporary_item')->insert($testData);
    $insertId = $db->insertID();
    
    if ($result && $insertId) {
        echo "✅ Berhasil insert ke temporary_item!\n";
        echo "🆔 ID baru: {$insertId}\n\n";
        
        // Cek data yang baru diinsert
        $newRecord = $db->table('temporary_item')->where('id_temporary', $insertId)->get()->getRowArray();
        echo "📋 Record yang baru dibuat:\n";
        print_r($newRecord);
        
    } else {
        echo "❌ Gagal insert\n";
        echo "Error: " . $db->error()['message'] . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🔍 Data temporary_item dengan status pending:\n";

$pendingItems = $db->table('temporary_item')
    ->where('status', 'pending')
    ->orderBy('created_at', 'DESC')
    ->limit(5)
    ->get()
    ->getResultArray();

if (empty($pendingItems)) {
    echo "❌ Tidak ada data pending\n";
} else {
    echo "✅ Ditemukan " . count($pendingItems) . " item pending:\n";
    foreach ($pendingItems as $item) {
        echo sprintf(
            "- ID: %s | Nama: %s | Lokasi: %s | Status: %s\n",
            $item['id_temporary'],
            $item['nama_barang_baru'],
            $item['lokasi_barang_baru'] ?? 'NULL',
            $item['status']
        );
    }
}