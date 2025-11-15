<?php

$db = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "=== CEK TRIGGER DI DATABASE ===\n\n";

// Cek semua trigger
$stmt = $db->query("SHOW TRIGGERS");
$triggers = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($triggers) > 0) {
    foreach ($triggers as $trigger) {
        echo "Trigger: {$trigger['Trigger']}\n";
        echo "Table: {$trigger['Table']}\n";
        echo "Timing: {$trigger['Timing']}\n";
        echo "Event: {$trigger['Event']}\n";
        echo "\nStatement:\n";
        echo str_repeat("-", 70) . "\n";
        echo $trigger['Statement'] . "\n";
        echo str_repeat("-", 70) . "\n\n";
    }
} else {
    echo "❌ Tidak ada trigger di database\n";
}

// Cek struktur tabel pengaduan
echo "\n=== STRUKTUR TABEL PENGADUAN ===\n\n";
$stmt = $db->query("SHOW COLUMNS FROM pengaduan");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($columns as $col) {
    echo "{$col['Field']} - {$col['Type']}\n";
}
