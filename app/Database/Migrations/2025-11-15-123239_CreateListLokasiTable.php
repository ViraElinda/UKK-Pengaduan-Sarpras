<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateListLokasiTable extends Migration
{
    public function up()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'list_lokasi'");
        if ($query->getNumRows() == 0) {
            $fields = [
                'id_list' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => false,
                    'auto_increment' => true,
                ],
                'id_lokasi' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'id_item' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
            ];

            $this->forge->addField($fields);
            $this->forge->addKey('id_list', true);
            $this->forge->addKey('id_lokasi');
            $this->forge->addKey('id_item');
            $this->forge->createTable('list_lokasi');

            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Created list_lokasi table successfully');
            }
        } else {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] list_lokasi table already exists, skipping creation');
            }
        }
    }

    public function down()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'list_lokasi'");
        if ($query->getNumRows() > 0) {
            $this->forge->dropTable('list_lokasi');
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Dropped list_lokasi table');
            }
        }
    }
}
