<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTemporaryItemTable extends Migration
{
    public function up()
    {
        // Create temporary_item table if it doesn't exist
        $query = $this->db->query("SHOW TABLES LIKE 'temporary_item'");
        if ($query->getNumRows() == 0) {
            $fields = [
                'id_temporary' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'id_item' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
                'nama_barang_baru' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => false,
                ],
                'lokasi_barang_baru' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['pending', 'approved', 'rejected'],
                    'default'    => 'pending',
                ],
                'created_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                    'default' => 'CURRENT_TIMESTAMP',
                ],
                'updated_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                    'default' => 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                ],
            ];

            $this->forge->addField($fields);
            $this->forge->addKey('id_temporary', true);
            $this->forge->addKey('lokasi_barang_baru');
            $this->forge->createTable('temporary_item');

            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Created temporary_item table successfully');
            }
        } else {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] temporary_item table already exists, skipping creation');
            }
        }
    }

    public function down()
    {
        // Drop temporary_item table if it exists
        $query = $this->db->query("SHOW TABLES LIKE 'temporary_item'");
        if ($query->getNumRows() > 0) {
            $this->forge->dropTable('temporary_item');
            
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Dropped temporary_item table');
            }
        }
    }
}
