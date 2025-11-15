<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTemporaryItemLokasi extends Migration
{
    public function up()
    {
        // Hapus foreign key constraint
        $this->forge->dropForeignKey('temporary_item', 'fk_temp_lokasi');
        
        // Ubah kolom lokasi_barang_baru dari INT menjadi VARCHAR untuk menyimpan nama lokasi
        $this->forge->modifyColumn('temporary_item', [
            'lokasi_barang_baru' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
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
