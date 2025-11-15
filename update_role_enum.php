<?php

// Script sederhana untuk update role enum di database
// Jalankan: php update_role_enum.php

// Ganti dengan credential database Anda
$hostname = 'localhost';
$username = 'root';  // Ganti jika berbeda
$password = '';      // Ganti jika ada password
$database = 'pengaduan_sarpras';  // Ganti dengan nama database Anda

// Koneksi manual ke MySQL
$conn = new mysqli($hostname, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\nPastikan kredensial database sudah benar!\n");
}

echo "Connected to database successfully!\n";
echo "Updating user table role column...\n";

try {
    // Ubah struktur ENUM
    $sql = "ALTER TABLE `user` MODIFY COLUMN `role` ENUM('admin', 'petugas', 'user') NOT NULL";
    
    if ($conn->query($sql) === TRUE) {
        echo "✓ Role column updated successfully!\n\n";
    } else {
        echo "Error updating role column: " . $conn->error . "\n";
    }
    
    // Update existing guru dan siswa menjadi user
    echo "Updating existing guru and siswa to user...\n";
    $sql2 = "UPDATE `user` SET `role` = 'user' WHERE `role` IN ('guru', 'siswa')";
    
    if ($conn->query($sql2) === TRUE) {
        echo "✓ Updated " . $conn->affected_rows . " rows.\n\n";
    } else {
        echo "Error updating records: " . $conn->error . "\n";
    }
    
    echo "Migration completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

$conn->close();
