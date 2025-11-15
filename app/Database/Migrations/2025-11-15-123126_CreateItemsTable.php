<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItemsTable extends Migration
{
    public function up()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'items'");
        if ($query->getNumRows() == 0) {
            $fields = [
                'id_item' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => false,
                    'auto_increment' => true,
                ],
                'id_temporary' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'nama_item' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 200,
                ],
                'lokasi' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 200,
                    'null'       => true,
                ],
                'deskripsi' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'foto' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'id_lokasi' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
            ];

            $this->forge->addField($fields);
            $this->forge->addKey('id_item', true);
            $this->forge->addKey('id_temporary');
            $this->forge->createTable('items');

            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Created items table successfully');
            }
        } else {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] items table already exists, skipping creation');
            }
        }
    }

    public function down()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'items'");
        if ($query->getNumRows() > 0) {
            $this->forge->dropTable('items');
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Dropped items table');
            }
        }
    }
}
