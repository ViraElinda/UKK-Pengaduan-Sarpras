<?php
$mysqli = new mysqli('localhost', 'root', '', 'pengaduan_sarpras');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Update beberapa pengaduan dengan data lokasi
$updates = [
    ['id' => 132, 'id_lokasi' => 1, 'lokasi' => 'Ruang Kelas 1'],
    ['id' => 131, 'id_lokasi' => 2, 'lokasi' => 'Ruang Kelas 2'],
    ['id' => 130, 'id_lokasi' => 3, 'lokasi' => 'Laboratorium Komputer'],
];

foreach ($updates as $update) {
    $stmt = $mysqli->prepare("UPDATE pengaduan SET id_lokasi = ?, lokasi = ? WHERE id_pengaduan = ?");
    $stmt->bind_param("isi", $update['id_lokasi'], $update['lokasi'], $update['id']);
    $stmt->execute();
    echo "✅ Updated pengaduan {$update['id']} with lokasi: {$update['lokasi']}\n";
}

// Verify
echo "\n=== VERIFIKASI DATA ===\n";
$result = $mysqli->query("SELECT id_pengaduan, nama_pengaduan, id_lokasi, lokasi FROM pengaduan WHERE id_pengaduan IN (130,131,132)");
while ($row = $result->fetch_assoc()) {
    echo "ID: {$row['id_pengaduan']} | {$row['nama_pengaduan']} | id_lokasi: {$row['id_lokasi']} | lokasi: {$row['lokasi']}\n";
}

$mysqli->close();
echo "\n✅ Selesai!\n";
