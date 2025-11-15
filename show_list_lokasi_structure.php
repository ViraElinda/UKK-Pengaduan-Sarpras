<?php

$db = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$stmt = $db->query('SHOW COLUMNS FROM list_lokasi');

echo "=== STRUKTUR TABEL list_lokasi ===\n\n";
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
