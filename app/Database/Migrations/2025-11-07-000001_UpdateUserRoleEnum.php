<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserRoleEnum extends Migration
{
    public function up()
    {
        // Ensure user table exists before checking/modifying role column
        $tableCheck = $this->db->query("SHOW TABLES LIKE 'user'");
        if ($tableCheck->getNumRows() == 0) {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] user table does not exist, skipping UpdateUserRoleEnum');
            }
            return;
        }

        // Check current role enum values
        $query = $this->db->query("SHOW COLUMNS FROM `user` LIKE 'role'");
        $result = $query->getRow();
        
        if ($result && isset($result->Type)) {
            $currentType = $result->Type;
            
            // Check if role enum already has correct structure
            if (strpos($currentType, "enum('admin','petugas','user')") !== false) {
                // Structure is already correct, no action needed
                if (function_exists('log_message')) {
                    log_message('info', '[MIGRATION] User role enum already has correct structure (admin,petugas,user), skipping update');
                }
                return;
            }
            
            // Only update if current enum still has old values (guru, siswa)
            if (strpos($currentType, 'guru') !== false || strpos($currentType, 'siswa') !== false) {
                // First update existing guru and siswa to user
                $this->db->query("UPDATE `user` SET `role` = 'user' WHERE `role` IN ('guru', 'siswa')");
                
                // Then update the ENUM to new structure
                $sql = "ALTER TABLE `user` MODIFY COLUMN `role` ENUM('admin', 'petugas', 'user') NOT NULL";
                $this->db->query($sql);
                
                if (function_exists('log_message')) {
                    log_message('info', '[MIGRATION] Updated user role enum from old structure to (admin,petugas,user)');
                }
            } else {
                if (function_exists('log_message')) {
                    log_message('info', '[MIGRATION] User role enum structure is compatible, no changes needed');
                }
            }
        }
    }

    public function down()
    {
        // Ensure user table exists before attempting rollback
        $tableCheck = $this->db->query("SHOW TABLES LIKE 'user'");
        if ($tableCheck->getNumRows() == 0) {
            return;
        }

        // Check if we need to rollback
        $query = $this->db->query("SHOW COLUMNS FROM `user` LIKE 'role'");
        $result = $query->getRow();
        
        if ($result && isset($result->Type)) {
            $currentType = $result->Type;
            
            // Only rollback if current structure is the new one
            if (strpos($currentType, 'admin') !== false && strpos($currentType, 'user') !== false) {
                // Rollback to old structure (if needed)
                $sql = "ALTER TABLE `user` MODIFY COLUMN `role` ENUM('admin', 'guru', 'siswa', 'petugas') NOT NULL";
                $this->db->query($sql);
                
                if (function_exists('log_message')) {
                    log_message('info', '[MIGRATION] Rolled back user role enum to old structure');
                }
            }
        }
    }
}
