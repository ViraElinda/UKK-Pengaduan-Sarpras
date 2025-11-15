<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoBalasanToPengaduan extends Migration
{
    public function up()
    {
        // Check if column already exists before adding
        $query = $this->db->query("SHOW COLUMNS FROM pengaduan LIKE 'foto_balasan'");
        
        if ($query->getNumRows() == 0) {
            $fields = [
                'foto_balasan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'saran_petugas',
                    'comment'    => 'Foto balasan dari petugas untuk pengaduan'
                ],
            ];

            $this->forge->addColumn('pengaduan', $fields);
            
            // Log success for VPS debugging
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Successfully added foto_balasan column to pengaduan table');
            }
        } else {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] foto_balasan column already exists, skipping add operation');
            }
        }
    }

    public function down()
    {
        // Check if column exists before dropping (safe rollback for VPS)
        $query = $this->db->query("SHOW COLUMNS FROM pengaduan LIKE 'foto_balasan'");
        
        if ($query->getNumRows() > 0) {
            $this->forge->dropColumn('pengaduan', ['foto_balasan']);
            
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Successfully dropped foto_balasan column from pengaduan table');
            }
        } else {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] foto_balasan column does not exist, skipping drop operation');
            }
        }
    }
}
