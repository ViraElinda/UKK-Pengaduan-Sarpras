<?php

echo "=== HAPUS DATA LAMA & BUAT RELASI SPESIFIK ===\n\n";

$db = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1. Hapus semua data lama di list_lokasi
echo "1. Hapus data lama...\n";
$db->exec("DELETE FROM list_lokasi");
echo "   ✅ Tabel list_lokasi dikosongkan\n\n";

// 2. Ambil data lokasi dan items
$stmt = $db->query("SELECT id_lokasi, nama_lokasi FROM lokasi ORDER BY id_lokasi");
$lokasi_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->query("SELECT id_item, nama_item FROM items ORDER BY id_item");
$items_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "2. Data tersedia:\n";
echo "   Lokasi:\n";
foreach ($lokasi_list as $lok) {
    echo "      - ID {$lok['id_lokasi']}: {$lok['nama_lokasi']}\n";
}
echo "\n   Items:\n";
foreach ($items_list as $item) {
    echo "      - ID {$item['id_item']}: {$item['nama_item']}\n";
}
echo "\n";

// 3. Buat mapping item per lokasi (SPESIFIK)
echo "3. Buat relasi spesifik per lokasi...\n\n";

// Items yang tersedia: 27=print, 28=kursi, 29=meja
$mapping = [
    // Ruang Kelas 1 - Item untuk kelas (kursi & meja)
    1 => [28, 29], // kursi, meja
    
    // Ruang Kelas 2 - Item untuk kelas (kursi & meja)
    2 => [28, 29], // kursi, meja
    
    // Laboratorium Komputer - Item untuk lab komputer (semua)
    3 => [27, 28, 29], // print, kursi, meja
    
    // Perpustakaan - Item untuk perpustakaan (kursi & meja)
    4 => [28, 29], // kursi, meja (tidak ada print)
    
    // Ruang Guru - HANYA PRINT
    5 => [27], // print saja
];

$inserted = 0;
foreach ($mapping as $id_lokasi => $item_ids) {
    // Cari nama lokasi
    $lokasi_name = '';
    foreach ($lokasi_list as $lok) {
        if ($lok['id_lokasi'] == $id_lokasi) {
            $lokasi_name = $lok['nama_lokasi'];
            break;
        }
    }
    
    echo "   📍 {$lokasi_name} (ID: {$id_lokasi}):\n";
    
    foreach ($item_ids as $id_item) {
        // Cari nama item
        $item_name = '';
        foreach ($items_list as $item) {
            if ($item['id_item'] == $id_item) {
                $item_name = $item['nama_item'];
                break;
            }
        }
        
        // Insert relasi
        $stmt = $db->prepare("INSERT INTO list_lokasi (id_lokasi, id_item) VALUES (?, ?)");
        $stmt->execute([$id_lokasi, $id_item]);
        $inserted++;
        
        echo "      └─ {$item_name}\n";
    }
    echo "\n";
}

echo "4. Hasil:\n";
echo "   Total relasi ditambahkan: {$inserted}\n\n";

// 5. Verifikasi per lokasi
echo "5. Verifikasi (Items per Lokasi):\n";
echo str_repeat("-", 70) . "\n";

foreach ($lokasi_list as $lokasi) {
    $stmt = $db->prepare("
        SELECT i.id_item, i.nama_item 
        FROM list_lokasi ll
        JOIN items i ON i.id_item = ll.id_item
        WHERE ll.id_lokasi = ?
        ORDER BY i.nama_item
    ");
    $stmt->execute([$lokasi['id_lokasi']]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "   📍 {$lokasi['nama_lokasi']} ({$lokasi['id_lokasi']}):\n";
    if (count($items) > 0) {
        foreach ($items as $item) {
            echo "      ✅ {$item['nama_item']} (ID: {$item['id_item']})\n";
        }
    } else {
        echo "      ⚠️ Tidak ada item\n";
    }
    echo "\n";
}

echo str_repeat("=", 70) . "\n";
echo "✅ SELESAI!\n";
echo "🎯 Setiap lokasi sekarang punya items yang BERBEDA dan SPESIFIK.\n";
