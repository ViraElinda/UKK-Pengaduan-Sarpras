<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBeforeAfterPhotosToPengaduan extends Migration
{
    public function up()
    {
        // Ensure table exists before checking/adding columns
        $tableCheck = $this->db->query("SHOW TABLES LIKE 'pengaduan'");
        if ($tableCheck->getNumRows() == 0) {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] pengaduan table does not exist, skipping AddBeforeAfterPhotosToPengaduan');
            }
            return;
        }

        // Check if columns already exist before adding
        $beforeQuery = $this->db->query("SHOW COLUMNS FROM pengaduan LIKE 'foto_before'");
        $afterQuery = $this->db->query("SHOW COLUMNS FROM pengaduan LIKE 'foto_after'");
        
        $fieldsToAdd = [];
        
        if ($beforeQuery->getNumRows() == 0) {
            $fieldsToAdd['foto_before'] = [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'foto'
            ];
        }
        
        if ($afterQuery->getNumRows() == 0) {
            $fieldsToAdd['foto_after'] = [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'foto_before'
            ];
        }
        
        if (!empty($fieldsToAdd)) {
            $this->forge->addColumn('pengaduan', $fieldsToAdd);
            
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Added columns: ' . implode(', ', array_keys($fieldsToAdd)));
            }
        } else {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] foto_before and foto_after columns already exist, skipping');
            }
        }
    }

    public function down()
    {
        // If table doesn't exist, nothing to rollback
        $tableCheck = $this->db->query("SHOW TABLES LIKE 'pengaduan'");
        if ($tableCheck->getNumRows() == 0) {
            return;
        }

        $columnsToDrop = [];

        $beforeQuery = $this->db->query("SHOW COLUMNS FROM pengaduan LIKE 'foto_before'");
        $afterQuery = $this->db->query("SHOW COLUMNS FROM pengaduan LIKE 'foto_after'");
        
        if ($beforeQuery->getNumRows() > 0) {
            $columnsToDrop[] = 'foto_before';
        }
        
        if ($afterQuery->getNumRows() > 0) {
            $columnsToDrop[] = 'foto_after';
        }
        
        if (!empty($columnsToDrop)) {
            $this->forge->dropColumn('pengaduan', $columnsToDrop);
            
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Dropped columns: ' . implode(', ', $columnsToDrop));
            }
        }
    }
}
