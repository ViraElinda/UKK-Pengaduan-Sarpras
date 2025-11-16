<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTemporaryItemLokasi extends Migration
{
    public function up()
    {
        // Check if temporary_item table exists before altering
        $query = $this->db->query("SHOW TABLES LIKE 'temporary_item'");
        if ($query->getNumRows() == 0) {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] temporary_item table does not exist, skipping alter operation');
            }
            return;
        }
        
        // Check if lokasi_barang_baru column is already VARCHAR
        $columnQuery = $this->db->query("SHOW COLUMNS FROM temporary_item LIKE 'lokasi_barang_baru'");
        if ($columnQuery->getNumRows() > 0) {
            $column = $columnQuery->getRowArray();
            if (strpos(strtolower($column['Type']), 'varchar') !== false) {
                if (function_exists('log_message')) {
                    log_message('info', '[MIGRATION] lokasi_barang_baru is already VARCHAR, skipping alter');
                }
                return;
            }
        }
        
        // Hapus foreign key constraint jika ada
        try {
            $this->forge->dropForeignKey('temporary_item', 'fk_temp_lokasi');
        } catch (\Exception $e) {
            // Foreign key mungkin tidak ada, lanjutkan saja
        }
        
        // Ubah kolom lokasi_barang_baru dari INT menjadi VARCHAR untuk menyimpan nama lokasi
        $this->forge->modifyColumn('temporary_item', [
            'lokasi_barang_baru' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
        
        if (function_exists('log_message')) {
            log_message('info', '[MIGRATION] Successfully altered lokasi_barang_baru column to VARCHAR');
        }
    }

    public function down()
    {
        // Check if temporary_item table exists
        $query = $this->db->query("SHOW TABLES LIKE 'temporary_item'");
        if ($query->getNumRows() == 0) {
            return;
        }
        
        // Kembalikan ke INT jika rollback
        $this->forge->modifyColumn('temporary_item', [
            'lokasi_barang_baru' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
        
        // Tambahkan kembali foreign key
        $this->forge->addForeignKey('lokasi_barang_baru', 'lokasi', 'id_lokasi', 'CASCADE', 'CASCADE', 'fk_temp_lokasi');
    }
}
