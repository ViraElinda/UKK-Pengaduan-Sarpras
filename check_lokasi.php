<?php
$mysqli = new mysqli('localhost', 'root', '', 'pengaduan_sarpras');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Cek table lokasi
echo "=== TABLE LOKASI ===\n\n";
$result = $mysqli->query("SELECT * FROM lokasi");
while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id_lokasi'] . " | Nama: " . $row['nama_lokasi'] . "\n";
}

// Cek pengaduan dengan id_lokasi
echo "\n\n=== PENGADUAN DENGAN id_lokasi (3 terakhir) ===\n\n";
$result = $mysqli->query("SELECT p.id_pengaduan, p.nama_pengaduan, p.id_lokasi, p.lokasi, l.nama_lokasi 
                          FROM pengaduan p 
                          LEFT JOIN lokasi l ON p.id_lokasi = l.id_lokasi 
                          ORDER BY p.id_pengaduan DESC LIMIT 5");
while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row['id_pengaduan'] . 
         " | Nama: " . $row['nama_pengaduan'] . 
         " | id_lokasi: " . ($row['id_lokasi'] ?: 'NULL') . 
         " | lokasi (text): " . ($row['lokasi'] ?: 'NULL') . 
         " | nama_lokasi (join): " . ($row['nama_lokasi'] ?: 'NULL') . "\n";
}

$mysqli->close();
