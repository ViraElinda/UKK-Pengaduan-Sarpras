<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePetugasTable extends Migration
{
    public function up()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'petugas'");
        if ($query->getNumRows() == 0) {
            $fields = [
                'id_petugas' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => false,
                    'auto_increment' => true,
                ],
                'id_user' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'nama' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ];

            $this->forge->addField($fields);
            $this->forge->addKey('id_petugas', true);
            $this->forge->addKey('id_user');
            $this->forge->createTable('petugas');

            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Created petugas table successfully');
            }
        } else {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] petugas table already exists, skipping creation');
            }
        }
    }

    public function down()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'petugas'");
        if ($query->getNumRows() > 0) {
            $this->forge->dropTable('petugas');
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Dropped petugas table');
            }
        }
    }
}
