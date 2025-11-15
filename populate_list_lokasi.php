<?php

echo "=== POPULATE TABEL list_lokasi ===\n\n";

$db = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1. Cek data yang ada
echo "1. Cek data sebelum populate:\n";
$stmt = $db->query("SELECT COUNT(*) as total FROM list_lokasi");
$before = $stmt->fetch(PDO::FETCH_ASSOC);
echo "   Total relasi saat ini: {$before['total']}\n\n";

// 2. Ambil semua lokasi dan items
$stmt = $db->query("SELECT id_lokasi, nama_lokasi FROM lokasi");
$lokasi_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->query("SELECT id_item, nama_item FROM items");
$items_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "2. Data yang tersedia:\n";
echo "   Lokasi: " . count($lokasi_list) . "\n";
echo "   Items: " . count($items_list) . "\n\n";

// 3. Populate list_lokasi (setiap item ada di setiap lokasi)
echo "3. Populate list_lokasi...\n";

$inserted = 0;
foreach ($lokasi_list as $lokasi) {
    foreach ($items_list as $item) {
        // Cek apakah sudah ada
        $stmt = $db->prepare("
            SELECT id_list FROM list_lokasi 
            WHERE id_lokasi = ? AND id_item = ?
        ");
        $stmt->execute([$lokasi['id_lokasi'], $item['id_item']]);
        
        if (!$stmt->fetch()) {
            // Insert jika belum ada
            $stmt = $db->prepare("
                INSERT INTO list_lokasi (id_lokasi, id_item) 
                VALUES (?, ?)
            ");
            $stmt->execute([$lokasi['id_lokasi'], $item['id_item']]);
            $inserted++;
            
            echo "   ✅ {$lokasi['nama_lokasi']} → {$item['nama_item']}\n";
        }
    }
}

echo "\n4. Hasil:\n";
echo "   Relasi baru ditambahkan: {$inserted}\n\n";

// 5. Verifikasi
$stmt = $db->query("SELECT COUNT(*) as total FROM list_lokasi");
$after = $stmt->fetch(PDO::FETCH_ASSOC);
echo "   Total relasi sekarang: {$after['total']}\n\n";

// 6. Tampilkan sample data
echo "5. Sample relasi (per lokasi):\n";
echo str_repeat("-", 60) . "\n";

foreach ($lokasi_list as $lokasi) {
    $stmt = $db->prepare("
        SELECT i.nama_item 
        FROM list_lokasi ll
        JOIN items i ON i.id_item = ll.id_item
        WHERE ll.id_lokasi = ?
        LIMIT 3
    ");
    $stmt->execute([$lokasi['id_lokasi']]);
    $items = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (count($items) > 0) {
        echo "   📍 {$lokasi['nama_lokasi']}:\n";
        foreach ($items as $item_name) {
            echo "      └─ {$item_name}\n";
        }
        
        $stmt = $db->prepare("
            SELECT COUNT(*) as total 
            FROM list_lokasi 
            WHERE id_lokasi = ?
        ");
        $stmt->execute([$lokasi['id_lokasi']]);
        $total = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "      (Total: {$total['total']} items)\n\n";
    }
}

echo str_repeat("=", 60) . "\n";
echo "✅ SELESAI! Tabel list_lokasi sudah terisi.\n";
echo "🎉 Sekarang dropdown item di form pengaduan akan berfungsi!\n";
