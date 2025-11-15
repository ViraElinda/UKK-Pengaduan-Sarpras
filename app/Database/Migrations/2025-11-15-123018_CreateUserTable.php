<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        // Create user table if it doesn't exist
        $query = $this->db->query("SHOW TABLES LIKE 'user'");
        if ($query->getNumRows() == 0) {
            $fields = [
                'id_user' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => false,
                    'auto_increment' => true,
                ],
                'username' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'unique'     => true,
                ],
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'nama_pengguna' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'foto' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'role' => [
                    'type'       => 'ENUM',
                    'constraint' => ['admin', 'petugas', 'user'],
                ],
                'created_at' => [
                    'type'    => 'TIMESTAMP',
                    'null'    => true,
                    'default' => 'CURRENT_TIMESTAMP',
                ],
                'updated_at' => [
                    'type'    => 'TIMESTAMP',
                    'null'    => true,
                    'default' => 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                ],
                'deleted_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ];

            $this->forge->addField($fields);
            $this->forge->addKey('id_user', true);
            $this->forge->addUniqueKey('username');
            $this->forge->createTable('user');

            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Created user table successfully');
            }
        } else {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] user table already exists, skipping creation');
            }
        }
    }

    public function down()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'user'");
        if ($query->getNumRows() > 0) {
            $this->forge->dropTable('user');
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Dropped user table');
            }
        }
    }
}
