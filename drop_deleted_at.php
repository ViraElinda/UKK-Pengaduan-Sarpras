<?php

$host = 'localhost';
$dbname = 'pengaduan_sarpras';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Dropping 'deleted_at' column from 'petugas' table...\n";
    
    $db->exec("ALTER TABLE petugas DROP COLUMN deleted_at");
    
    echo "✅ Column 'deleted_at' dropped successfully!\n";
    echo "Now petugas can login without errors.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
