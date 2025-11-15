<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLokasiTable extends Migration
{
    public function up()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'lokasi'");
        if ($query->getNumRows() == 0) {
            $fields = [
                'id_lokasi' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => false,
                    'auto_increment' => true,
                ],
                'nama_lokasi' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 200,
                ],
            ];

            $this->forge->addField($fields);
            $this->forge->addKey('id_lokasi', true);
            $this->forge->createTable('lokasi');

            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Created lokasi table successfully');
            }
        } else {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] lokasi table already exists, skipping creation');
            }
        }
    }

    public function down()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'lokasi'");
        if ($query->getNumRows() > 0) {
            $this->forge->dropTable('lokasi');
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Dropped lokasi table');
            }
        }
    }
}
