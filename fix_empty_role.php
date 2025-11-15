<?php

// Koneksi database langsung
$host = 'localhost';
$database = 'pengaduan_sarpras';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Update semua user yang role-nya kosong atau NULL menjadi 'user'
$stmt = $db->prepare("UPDATE user SET role = 'user' WHERE role IS NULL OR role = ''");
$stmt->execute();
$affected = $stmt->rowCount();

echo "Updated {$affected} rows.\n";

// Tampilkan semua user
$stmt = $db->query("SELECT id_user, username, nama_pengguna, role FROM user ORDER BY id_user");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "\nDaftar User:\n";
echo str_repeat("-", 80) . "\n";
printf("%-10s %-15s %-20s %-10s\n", "ID", "Username", "Nama", "Role");
echo str_repeat("-", 80) . "\n";

foreach ($users as $user) {
    printf(
        "%-10s %-15s %-20s %-10s\n",
        $user['id_user'],
        $user['username'],
        $user['nama_pengguna'],
        $user['role'] ?: '(kosong)'
    );
}

echo str_repeat("-", 80) . "\n";
echo "Done!\n";
