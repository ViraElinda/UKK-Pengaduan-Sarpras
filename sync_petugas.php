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

// Ambil semua user dengan role petugas
$stmt = $db->query("SELECT * FROM user WHERE role = 'petugas'");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "=== SYNC USER PETUGAS KE TABEL PETUGAS ===\n\n";
echo "Found " . count($users) . " user(s) with role 'petugas'\n\n";

$synced = 0;
$skipped = 0;

foreach ($users as $user) {
    $idUser = $user['id_user'];
    $nama = $user['nama_pengguna'];
    
    // Cek apakah sudah ada di tabel petugas
    $stmt = $db->prepare("SELECT * FROM petugas WHERE id_user = ?");
    $stmt->execute([$idUser]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$existing) {
        // Insert ke tabel petugas
        $stmt = $db->prepare("INSERT INTO petugas (id_user, nama, created_at) VALUES (?, ?, ?)");
        $stmt->execute([
            $idUser,
            $nama,
            date('Y-m-d H:i:s')
        ]);
        
        echo "✅ Synced: {$nama} (ID User: {$idUser})\n";
        $synced++;
    } else {
        echo "⏭️ Skipped: {$nama} (ID User: {$idUser}) - Already exists in petugas table\n";
        $skipped++;
    }
}

echo "\n=== SUMMARY ===\n";
echo "Synced: {$synced}\n";
echo "Skipped: {$skipped}\n";
echo "Total: " . count($users) . "\n";
echo "\nDone!\n";
