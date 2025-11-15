<?php

/**
 * PANDUAN MENGELOLA RELASI ITEM-LOKASI
 * 
 * Script ini membantu Anda menambah, hapus, atau edit
 * relasi antara items dan lokasi secara mudah.
 */

$db = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║       KELOLA RELASI ITEM-LOKASI (list_lokasi)                 ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Ambil semua lokasi
$stmt = $db->query("SELECT id_lokasi, nama_lokasi FROM lokasi ORDER BY id_lokasi");
$lokasi_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil semua items
$stmt = $db->query("SELECT id_item, nama_item FROM items ORDER BY id_item");
$items_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "📋 DAFTAR LOKASI:\n";
echo str_repeat("-", 70) . "\n";
foreach ($lokasi_list as $lok) {
    echo sprintf("   [%d] %s\n", $lok['id_lokasi'], $lok['nama_lokasi']);
}

echo "\n📦 DAFTAR ITEMS:\n";
echo str_repeat("-", 70) . "\n";
foreach ($items_list as $item) {
    echo sprintf("   [%d] %s\n", $item['id_item'], $item['nama_item']);
}

echo "\n\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "RELASI SAAT INI:\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

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
    
    echo "📍 {$lokasi['nama_lokasi']} (ID: {$lokasi['id_lokasi']})\n";
    if (count($items) > 0) {
        $item_names = array_map(function($item) {
            return $item['nama_item'];
        }, $items);
        echo "   Items: " . implode(", ", $item_names) . "\n";
        echo "   Total: " . count($items) . " items\n";
    } else {
        echo "   ⚠️ Belum ada items\n";
    }
    echo "\n";
}

echo "═══════════════════════════════════════════════════════════════\n\n";

echo "💡 CARA MENGGUNAKAN:\n";
echo "───────────────────────────────────────────────────────────────\n";
echo "1. TAMBAH ITEM KE LOKASI:\n";
echo "   Edit file 'populate_list_lokasi_spesifik.php'\n";
echo "   Contoh tambah 'bantal' (ID 10) ke Ruang Kelas 1:\n";
echo "   1 => [26, 28, 29, 10],\n\n";

echo "2. HAPUS ITEM DARI LOKASI:\n";
echo "   Hapus ID item dari array lokasi tersebut\n";
echo "   Contoh hapus 'kursi' (ID 28) dari Ruang Kelas 1:\n";
echo "   1 => [26, 29], // hapus 28\n\n";

echo "3. TAMBAH LOKASI BARU:\n";
echo "   Tambah entry baru di mapping:\n";
echo "   6 => [26, 27, 29], // Ruang Kelas 3\n\n";

echo "4. JALANKAN ULANG:\n";
echo "   php populate_list_lokasi_spesifik.php\n\n";

echo "═══════════════════════════════════════════════════════════════\n\n";

echo "📊 STATISTIK:\n";
$stmt = $db->query("SELECT COUNT(*) as total FROM list_lokasi");
$total = $stmt->fetch(PDO::FETCH_ASSOC);
echo "   Total relasi: {$total['total']}\n";

$stmt = $db->query("SELECT COUNT(DISTINCT id_lokasi) as total FROM list_lokasi");
$total_lokasi = $stmt->fetch(PDO::FETCH_ASSOC);
echo "   Lokasi yang punya items: {$total_lokasi['total']} dari " . count($lokasi_list) . "\n";

$stmt = $db->query("SELECT COUNT(DISTINCT id_item) as total FROM list_lokasi");
$total_items = $stmt->fetch(PDO::FETCH_ASSOC);
echo "   Items yang digunakan: {$total_items['total']} dari " . count($items_list) . "\n";

echo "\n";
