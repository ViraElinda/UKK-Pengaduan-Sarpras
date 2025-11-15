<?php

echo "=== ALTER TABLE: Tambah 'user' ke ENUM role ===\n\n";

$db = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');

// 1. Cek struktur awal
echo "1. Struktur SEBELUM:\n";
$stmt = $db->query('SHOW COLUMNS FROM user LIKE "role"');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo "   Type: " . $row['Type'] . "\n\n";

// 2. ALTER TABLE - tambah 'user' ke ENUM
echo "2. Menjalankan ALTER TABLE...\n";
try {
    $sql = "ALTER TABLE user MODIFY COLUMN role ENUM('admin', 'petugas', 'user', 'guru', 'siswa') NOT NULL";
    $db->exec($sql);
    echo "   ✅ Berhasil!\n\n";
} catch (PDOException $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n\n";
    exit(1);
}

// 3. Cek struktur setelah
echo "3. Struktur SETELAH:\n";
$stmt = $db->query('SHOW COLUMNS FROM user LIKE "role"');
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo "   Type: " . $row['Type'] . "\n\n";

// 4. Update user yang role-nya kosong
echo "4. Update user dengan role kosong menjadi 'user'...\n";
$stmt = $db->prepare("UPDATE user SET role = 'user' WHERE role IS NULL OR role = ''");
$stmt->execute();
$affected = $stmt->rowCount();
echo "   ✅ Updated {$affected} rows\n\n";

// 5. Tampilkan semua user
echo "5. Daftar semua user:\n";
echo str_repeat("-", 80) . "\n";
printf("%-5s %-15s %-20s %-10s\n", "ID", "Username", "Nama", "Role");
echo str_repeat("-", 80) . "\n";

$stmt = $db->query("SELECT id_user, username, nama_pengguna, role FROM user ORDER BY id_user");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    printf(
        "%-5s %-15s %-20s %-10s\n",
        $user['id_user'],
        $user['username'],
        substr($user['nama_pengguna'], 0, 20),
        $user['role']
    );
}

echo str_repeat("-", 80) . "\n";
echo "\n✅ SELESAI! Role 'user' sudah ditambahkan ke database.\n";
