<?php
// Script untuk cek user dan buat notifikasi
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'pengaduan_sarpras';

try {
    $conn = new mysqli($host, $user, $pass, $db);
    
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    
    echo "✓ Koneksi database berhasil\n\n";
    
    // Cek user yang ada
    $result = $conn->query("SELECT id_user, username, role FROM user ORDER BY id_user LIMIT 5");
    echo "User yang tersedia di database:\n";
    echo "================================\n";
    $users = [];
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id_user']}, Username: {$row['username']}, Role: {$row['role']}\n";
        $users[] = $row['id_user'];
    }
    echo "\n";
    
    if (empty($users)) {
        echo "✗ Tidak ada user di database. Silakan buat user terlebih dahulu.\n";
        exit;
    }
    
    // Cek apakah sudah ada notifikasi
    $check = $conn->query("SELECT COUNT(*) as total FROM notif");
    $row = $check->fetch_assoc();
    
    if ($row['total'] > 0) {
        echo "⚠ Sudah ada {$row['total']} notifikasi di database\n\n";
        
        // Tampilkan notifikasi yang ada
        $result = $conn->query("SELECT n.*, u.username FROM notif n JOIN user u ON n.id_user = u.id_user ORDER BY n.created_at DESC");
        echo "Notifikasi yang ada:\n";
        echo "====================\n";
        while ($row = $result->fetch_assoc()) {
            $status = $row['is_read'] == 0 ? '🔴 BELUM DIBACA' : '✓ Sudah dibaca';
            echo "- [{$status}] {$row['judul']}\n";
            echo "  User: {$row['username']} (ID: {$row['id_user']})\n";
            echo "  Pesan: {$row['pesan']}\n";
            echo "  Tipe: {$row['tipe']}\n";
            echo "  Waktu: {$row['created_at']}\n\n";
        }
    } else {
        echo "📝 Membuat notifikasi sample untuk user yang ada...\n\n";
        
        // Buat notifikasi untuk setiap user
        foreach ($users as $userId) {
            $stmt = $conn->prepare("INSERT INTO notif (id_user, judul, pesan, tipe, link) VALUES (?, ?, ?, ?, ?)");
            
            $judul = "Selamat Datang di Sistem Pengaduan Sarpras!";
            $pesan = "Terima kasih telah bergabung. Anda dapat mulai menggunakan sistem untuk melaporkan masalah sarana dan prasarana.";
            $tipe = "success";
            $link = null;
            
            $stmt->bind_param("issss", $userId, $judul, $pesan, $tipe, $link);
            
            if ($stmt->execute()) {
                echo "✓ Notifikasi dibuat untuk user ID: $userId\n";
            } else {
                echo "✗ Error untuk user ID $userId: " . $stmt->error . "\n";
            }
            
            $stmt->close();
        }
        
        echo "\n✅ SELESAI! Notifikasi berhasil dibuat.\n\n";
        
        // Tampilkan hasil
        $result = $conn->query("SELECT n.*, u.username FROM notif n JOIN user u ON n.id_user = u.id_user");
        echo "Notifikasi yang dibuat:\n";
        echo "=======================\n";
        while ($row = $result->fetch_assoc()) {
            echo "- User: {$row['username']} (ID: {$row['id_user']})\n";
            echo "  Judul: {$row['judul']}\n";
            echo "  Tipe: {$row['tipe']}\n\n";
        }
    }
    
    echo "\n💡 Cara melihat notifikasi:\n";
    echo "1. Login ke sistem dengan salah satu user di atas\n";
    echo "2. Lihat icon bell 🔔 di navbar (akan ada badge angka merah)\n";
    echo "3. Klik bell icon untuk melihat notifikasi\n";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
