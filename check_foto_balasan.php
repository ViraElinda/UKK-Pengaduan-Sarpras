<?php
$pdo = new PDO('mysql:host=localhost;dbname=pengaduan_sarpras', 'root', '');
$stmt = $pdo->query('SELECT id_pengaduan, nama_pengaduan, id_user, foto_balasan, saran_petugas FROM pengaduan WHERE id_pengaduan = 160');
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo "✅ Data ditemukan:\n";
    echo "ID: {$row['id_pengaduan']}\n";
    echo "Nama: {$row['nama_pengaduan']}\n";
    echo "User ID: {$row['id_user']}\n";
    echo "Foto Balasan: " . ($row['foto_balasan'] ?: 'NULL') . "\n";
    echo "Saran: " . ($row['saran_petugas'] ?: 'NULL') . "\n";
    
    echo "\n📌 Untuk melihatnya, user dengan id_user = {$row['id_user']} harus login\n";
    
    // Cek username user
    $stmt2 = $pdo->query("SELECT username, nama_pengguna FROM user WHERE id_user = {$row['id_user']}");
    $user = $stmt2->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo "Username: {$user['username']}\n";
        echo "Nama: {$user['nama_pengguna']}\n";
    }
} else {
    echo "❌ Data tidak ditemukan\n";
}
