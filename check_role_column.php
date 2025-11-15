<?php

// Cek struktur kolom role
$db = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$stmt = $db->query('SHOW COLUMNS FROM user LIKE "role"');
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Struktur kolom 'role':\n";
echo "Type: " . $row['Type'] . "\n";
echo "Null: " . $row['Null'] . "\n";
echo "Default: " . $row['Default'] . "\n\n";

// Cek data user yang role kosong
$stmt = $db->query("SELECT id_user, username, nama_pengguna, role FROM user WHERE role IS NULL OR role = ''");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "User dengan role kosong:\n";
foreach ($users as $user) {
    echo "- {$user['username']} (ID: {$user['id_user']})\n";
}
