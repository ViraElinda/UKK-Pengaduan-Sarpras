-- SQL to create notif table for in-app notifications
-- Run this in your MySQL client or phpMyAdmin for the project's database (pengaduan_sarpras)

DROP TABLE IF EXISTS `notif`;

CREATE TABLE `notif` (
  `id_notif` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `judul` VARCHAR(255) NOT NULL,
  `pesan` TEXT NOT NULL,
  `tipe` ENUM('info','success','warning','danger') DEFAULT 'info',
  `is_read` TINYINT(1) DEFAULT 0,
  `link` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_user_read` (`id_user`, `is_read`),
  INDEX `idx_created` (`created_at`),
  CONSTRAINT `fk_notif_user` FOREIGN KEY (`id_user`) REFERENCES `user`(`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
