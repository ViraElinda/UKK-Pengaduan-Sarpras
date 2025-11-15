-- Tabel Notifikasi untuk semua role
CREATE TABLE IF NOT EXISTS notif (
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

-- Sample data untuk testing
INSERT INTO notif (id_user, judul, pesan, tipe, link) VALUES
(1, 'Selamat Datang!', 'Terima kasih telah bergabung dengan sistem Pengaduan Sarpras', 'success', NULL),
(2, 'Pengaduan Diproses', 'Pengaduan Anda sedang ditangani oleh petugas', 'info', '/user/detail/1');
