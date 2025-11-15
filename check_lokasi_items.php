<?php

echo "=== CEK DATA LOKASI DAN ITEMS ===\n\n";

$db = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1. Cek Tabel Lokasi
echo "1. DAFTAR LOKASI:\n";
echo str_repeat("-", 60) . "\n";
$stmt = $db->query("SELECT id_lokasi, nama_lokasi FROM lokasi ORDER BY id_lokasi");
$lokasi_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($lokasi_list) > 0) {
    foreach ($lokasi_list as $lok) {
        echo "   ID: {$lok['id_lokasi']} - {$lok['nama_lokasi']}\n";
    }
} else {
    echo "   ⚠️ Tidak ada data lokasi!\n";
}

echo "\n";

// 2. Cek Tabel Items
echo "2. DAFTAR ITEMS:\n";
echo str_repeat("-", 60) . "\n";
$stmt = $db->query("SELECT id_item, nama_item FROM items ORDER BY id_item LIMIT 10");
$items_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($items_list) > 0) {
    foreach ($items_list as $item) {
        echo "   ID: {$item['id_item']} - {$item['nama_item']}\n";
    }
    
    $stmt = $db->query("SELECT COUNT(*) as total FROM items");
    $total = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "   ... (Total: {$total['total']} items)\n";
} else {
    echo "   ⚠️ Tidak ada data items!\n";
}

echo "\n";

// 3. Cek Tabel list_lokasi (relasi lokasi-item)
echo "3. RELASI LOKASI-ITEM (list_lokasi):\n";
echo str_repeat("-", 60) . "\n";
$stmt = $db->query("
    SELECT 
        ll.id_list,
        ll.id_lokasi,
        l.nama_lokasi,
        ll.id_item,
        i.nama_item
    FROM list_lokasi ll
    LEFT JOIN lokasi l ON l.id_lokasi = ll.id_lokasi
    LEFT JOIN items i ON i.id_item = ll.id_item
    ORDER BY ll.id_lokasi, ll.id_item
    LIMIT 20
");
$list_lokasi = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($list_lokasi) > 0) {
    $current_lokasi = null;
    foreach ($list_lokasi as $row) {
        if ($current_lokasi != $row['nama_lokasi']) {
            echo "\n   📍 {$row['nama_lokasi']} (ID: {$row['id_lokasi']})\n";
            $current_lokasi = $row['nama_lokasi'];
        }
        echo "      └─ {$row['nama_item']} (ID: {$row['id_item']})\n";
    }
    
    $stmt = $db->query("SELECT COUNT(*) as total FROM list_lokasi");
    $total = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "\n   Total relasi: {$total['total']}\n";
} else {
    echo "   ⚠️ Tidak ada data relasi lokasi-item!\n";
    echo "   ❌ MASALAH: Tabel list_lokasi kosong!\n";
    echo "   💡 Solusi: Isi tabel list_lokasi dengan data relasi lokasi dan item\n";
}

echo "\n";

// 4. Test Query untuk ID Lokasi tertentu
if (count($lokasi_list) > 0) {
    $test_id = $lokasi_list[0]['id_lokasi'];
    echo "4. TEST QUERY untuk Lokasi ID {$test_id}:\n";
    echo str_repeat("-", 60) . "\n";
    
    $stmt = $db->prepare("
        SELECT 
            i.id_item, 
            i.nama_item
        FROM list_lokasi ll
        LEFT JOIN items i ON i.id_item = ll.id_item
        WHERE ll.id_lokasi = ?
    ");
    $stmt->execute([$test_id]);
    $test_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($test_items) > 0) {
        echo "   ✅ Query berhasil! Items di lokasi ID {$test_id}:\n";
        foreach ($test_items as $item) {
            echo "      - {$item['nama_item']} (ID: {$item['id_item']})\n";
        }
    } else {
        echo "   ⚠️ Tidak ada items untuk lokasi ID {$test_id}\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "KESIMPULAN:\n";

if (count($lokasi_list) == 0) {
    echo "❌ Tabel 'lokasi' kosong\n";
}
if (count($items_list) == 0) {
    echo "❌ Tabel 'items' kosong\n";
}
if (count($list_lokasi) == 0) {
    echo "❌ Tabel 'list_lokasi' kosong - INI PENYEBAB UTAMA!\n";
    echo "💡 Solusi: Jalankan script untuk populate list_lokasi\n";
} else {
    echo "✅ Semua tabel terisi dengan baik\n";
}
