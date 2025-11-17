<?php

// Simple database connection
$host = 'localhost';
$dbname = 'pengaduan_sarpras';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

echo "=== TEST LOGIN PETUGAS ===\n\n";

// Ambil user dengan role petugas
$stmt = $db->query("SELECT * FROM user WHERE role = 'petugas' LIMIT 1");
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("❌ Tidak ada user dengan role petugas\n");
}

echo "✅ User ditemukan:\n";
echo "   - ID: {$user['id_user']}\n";
echo "   - Username: {$user['username']}\n";
echo "   - Nama: {$user['nama_pengguna']}\n";
echo "   - Role: {$user['role']}\n\n";

// Cek apakah ada di tabel petugas
$stmt = $db->prepare("SELECT * FROM petugas WHERE id_user = ?");
$stmt->execute([$user['id_user']]);
$petugas = $stmt->fetch(PDO::FETCH_ASSOC);

if ($petugas) {
    echo "✅ Data petugas ditemukan:\n";
    echo "   - ID Petugas: {$petugas['id_petugas']}\n";
    echo "   - Nama: {$petugas['nama']}\n";
    echo "   - ID User: {$petugas['id_user']}\n\n";
    echo "✅ SEMUA DATA LENGKAP - LOGIN SEHARUSNYA BERHASIL!\n";
} else {
    echo "❌ Data petugas TIDAK ditemukan di tabel petugas\n";
    echo "⚠️ Perlu sync ulang!\n";
}

// Cek struktur tabel petugas
echo "\n=== STRUKTUR TABEL PETUGAS ===\n";
$stmt = $db->query("DESCRIBE petugas");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($columns as $col) {
    echo "- {$col['Field']} ({$col['Type']})\n";
}

echo "\n✅ Test selesai!\n";
