<?php
$mysqli = new mysqli('localhost', 'root', '', 'pengaduan_sarpras');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Cek struktur table pengaduan
echo "=== STRUKTUR TABLE PENGADUAN ===\n\n";
$result = $mysqli->query("DESCRIBE pengaduan");
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . " - " . ($row['Null'] == 'YES' ? 'NULL' : 'NOT NULL') . "\n";
}

// Cek sample data pengaduan
echo "\n\n=== SAMPLE DATA PENGADUAN (3 terakhir) ===\n\n";
$result = $mysqli->query("SELECT id_pengaduan, nama_pengaduan, lokasi FROM pengaduan ORDER BY id_pengaduan DESC LIMIT 3");
while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id_pengaduan'] . " | Nama: " . $row['nama_pengaduan'] . " | Lokasi: [" . ($row['lokasi'] ?: 'EMPTY/NULL') . "]\n";
}

$mysqli->close();
