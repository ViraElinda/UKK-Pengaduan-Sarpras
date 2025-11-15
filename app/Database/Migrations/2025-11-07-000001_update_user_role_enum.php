<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserRoleEnum_20251107000001 extends Migration
{
    public function up()
    {
        // Ubah ENUM role dari (admin, guru, siswa, petugas) menjadi (admin, petugas, user)
        $sql = "ALTER TABLE `user` MODIFY COLUMN `role` ENUM('admin', 'petugas', 'user') NOT NULL";
        $this->db->query($sql);
        
        // Optional: Update existing guru dan siswa menjadi user
        $this->db->query("UPDATE `user` SET `role` = 'user' WHERE `role` IN ('guru', 'siswa')");
    }

    public function down()
    {
        // Rollback ke struktur lama
        $sql = "ALTER TABLE `user` MODIFY COLUMN `role` ENUM('admin', 'guru', 'siswa', 'petugas') NOT NULL";
        $this->db->query($sql);
    }
}
