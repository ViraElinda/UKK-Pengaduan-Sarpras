<?php

$db = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

echo "=== DAFTAR ITEMS YANG TERSEDIA ===\n\n";

$stmt = $db->query("SELECT id_item, nama_item FROM items ORDER BY id_item");
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($items) > 0) {
    echo "ID   | Nama Item\n";
    echo "-----|-----------\n";
    foreach ($items as $item) {
        echo sprintf("%-4d | %s\n", $item['id_item'], $item['nama_item']);
    }
    echo "\nTotal: " . count($items) . " items\n";
} else {
    echo "❌ Tidak ada items di database!\n";
}
