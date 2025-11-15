-- Ubah kolom lokasi_barang_baru di tabel temporary_item
-- dari INT (foreign key) menjadi VARCHAR untuk menyimpan nama lokasi

-- 1. Hapus foreign key constraint
ALTER TABLE `temporary_item` DROP FOREIGN KEY `fk_temp_lokasi`;

-- 2. Ubah tipe kolom menjadi VARCHAR
ALTER TABLE `temporary_item` 
MODIFY COLUMN `lokasi_barang_baru` VARCHAR(255) NULL;

-- Selesai! Sekarang kolom lokasi_barang_baru bisa menyimpan nama lokasi sebagai text.
