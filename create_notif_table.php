<?php
/**
 * Script untuk membuat tabel notif (notifikasi)
 * Jalankan: php create_notif_table.php
 */

require 'vendor/autoload.php';

$db = \Config\Database::connect();

// Drop table jika sudah ada (untuk development)
$db->query("DROP TABLE IF EXISTS notif");

// Create table notif
$sql = "
CREATE TABLE notif (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

try {
    $db->query($sql);
    echo "✅ Tabel 'notif' berhasil dibuat!\n";
    echo "\nStruktur tabel:\n";
    echo "- id_notif: ID notifikasi (auto increment)\n";
    echo "- id_user: ID user penerima notifikasi\n";
    echo "- judul: Judul notifikasi\n";
    echo "- pesan: Isi pesan notifikasi\n";
    echo "- tipe: Jenis notifikasi (info/success/warning/danger)\n";
    echo "- is_read: Status baca (0=belum, 1=sudah)\n";
    echo "- link: Link terkait (opsional)\n";
    echo "- created_at: Waktu notifikasi dibuat\n";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
