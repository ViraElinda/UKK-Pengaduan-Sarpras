<?php
// Script untuk menghapus FK constraint dan mengubah kolom lokasi_barang_baru

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'pengaduan_sarpras';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek FK constraint yang ada
echo "Mengecek foreign key constraints...\n";
$result = $conn->query("
    SELECT CONSTRAINT_NAME 
    FROM information_schema.TABLE_CONSTRAINTS 
    WHERE TABLE_SCHEMA = 'pengaduan_sarpras' 
    AND TABLE_NAME = 'temporary_item' 
    AND CONSTRAINT_TYPE = 'FOREIGN KEY'
");

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $fk_name = $row['CONSTRAINT_NAME'];
        echo "Menghapus FK: $fk_name\n";
        $sql = "ALTER TABLE `temporary_item` DROP FOREIGN KEY `$fk_name`";
        if ($conn->query($sql) === TRUE) {
            echo "✓ FK $fk_name berhasil dihapus\n";
        } else {
            echo "Error: " . $conn->error . "\n";
        }
    }
} else {
    echo "Tidak ada FK constraint ditemukan\n";
}

echo "\nMengubah tipe kolom lokasi_barang_baru...\n";
$sql2 = "ALTER TABLE `temporary_item` MODIFY COLUMN `lokasi_barang_baru` VARCHAR(255) NULL";
if ($conn->query($sql2) === TRUE) {
    echo "✓ Kolom berhasil diubah menjadi VARCHAR(255)\n";
} else {
    echo "Error: " . $conn->error . "\n";
}

echo "\n✅ Selesai! Sekarang kolom lokasi_barang_baru bisa menyimpan nama lokasi.\n";

$conn->close();
