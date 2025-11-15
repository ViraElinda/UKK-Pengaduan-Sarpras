<?php
// Script untuk membuat tabel notif langsung
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
    
    // Cek apakah tabel sudah ada
    $check = $conn->query("SHOW TABLES LIKE 'notif'");
    if ($check->num_rows > 0) {
        echo "⚠ Tabel 'notif' sudah ada di database\n\n";
        
        // Tampilkan isi tabel
        $result = $conn->query("SELECT * FROM notif");
        echo "Isi tabel notif:\n";
        echo "================\n";
        while ($row = $result->fetch_assoc()) {
            echo "ID: {$row['id_notif']}, User: {$row['id_user']}, Judul: {$row['judul']}\n";
        }
        exit;
    }
    
    echo "📝 Membuat tabel 'notif'...\n";
    
    $sql = "CREATE TABLE IF NOT EXISTS notif (
        id_notif INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        judul VARCHAR(255) NOT NULL,
        pesan TEXT NOT NULL,
        tipe ENUM('info', 'success', 'warning', 'danger') DEFAULT 'info',
        is_read TINYINT(1) DEFAULT 0,
        link VARCHAR(255) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE,
        INDEX idx_user_read (id_user, is_read),
        INDEX idx_created (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql) === TRUE) {
        echo "✓ Tabel 'notif' berhasil dibuat\n\n";
    } else {
        echo "✗ Error membuat tabel: " . $conn->error . "\n";
        exit;
    }
    
    echo "📝 Menambahkan data sample...\n";
    
    $insert = "INSERT INTO notif (id_user, judul, pesan, tipe, link) VALUES
        (1, 'Selamat Datang!', 'Terima kasih telah bergabung dengan sistem Pengaduan Sarpras', 'success', NULL),
        (2, 'Pengaduan Diproses', 'Pengaduan Anda sedang ditangani oleh petugas', 'info', '/user/detail/1')";
    
    if ($conn->query($insert) === TRUE) {
        echo "✓ Data sample berhasil ditambahkan\n\n";
    } else {
        echo "✗ Error menambahkan data: " . $conn->error . "\n";
    }
    
    // Tampilkan hasil
    $result = $conn->query("SELECT * FROM notif");
    echo "Notifikasi yang berhasil dibuat:\n";
    echo "=================================\n";
    while ($row = $result->fetch_assoc()) {
        echo "- ID: {$row['id_notif']}\n";
        echo "  User ID: {$row['id_user']}\n";
        echo "  Judul: {$row['judul']}\n";
        echo "  Pesan: {$row['pesan']}\n";
        echo "  Tipe: {$row['tipe']}\n";
        echo "  Is Read: {$row['is_read']}\n\n";
    }
    
    echo "✅ SELESAI! Tabel notif siap digunakan.\n";
    echo "Silakan login dengan user id_user=1 atau id_user=2 untuk melihat notifikasi.\n";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
