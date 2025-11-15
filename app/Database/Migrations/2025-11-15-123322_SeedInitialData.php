<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SeedInitialData extends Migration
{
    public function up()
    {
        // Insert default admin user
        $userQuery = $this->db->query("SELECT COUNT(*) as count FROM user WHERE role = 'admin'");
        $userCount = $userQuery->getRowArray()['count'];
        
        if ($userCount == 0) {
            $adminData = [
                'username'      => 'admin',
                'password'      => password_hash('admin123', PASSWORD_DEFAULT),
                'nama_pengguna' => 'Administrator',
                'role'          => 'admin',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];
            
            $this->db->table('user')->insert($adminData);
            
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Created default admin user (admin/admin123)');
            }
        }
        
        // Insert default locations
        $lokasiQuery = $this->db->query("SELECT COUNT(*) as count FROM lokasi");
        $lokasiCount = $lokasiQuery->getRowArray()['count'];
        
        if ($lokasiCount == 0) {
            $defaultLokasi = [
                ['nama_lokasi' => 'Ruang Kelas 1'],
                ['nama_lokasi' => 'Ruang Kelas 2'],
                ['nama_lokasi' => 'Ruang Kelas 3'],
                ['nama_lokasi' => 'Laboratorium Komputer'],
                ['nama_lokasi' => 'Laboratorium IPA'],
                ['nama_lokasi' => 'Perpustakaan'],
                ['nama_lokasi' => 'Kantin'],
                ['nama_lokasi' => 'Toilet Siswa'],
                ['nama_lokasi' => 'Ruang Guru'],
                ['nama_lokasi' => 'Ruang Kepala Sekolah'],
            ];
            
            $this->db->table('lokasi')->insertBatch($defaultLokasi);
            
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Inserted ' . count($defaultLokasi) . ' default locations');
            }
        }
        
        // Insert some default items
        $itemQuery = $this->db->query("SELECT COUNT(*) as count FROM items");
        $itemCount = $itemQuery->getRowArray()['count'];
        
        if ($itemCount == 0) {
            $defaultItems = [
                ['nama_item' => 'Meja', 'deskripsi' => 'Meja untuk siswa'],
                ['nama_item' => 'Kursi', 'deskripsi' => 'Kursi untuk siswa'],
                ['nama_item' => 'Papan Tulis', 'deskripsi' => 'Papan tulis kelas'],
                ['nama_item' => 'Proyektor', 'deskripsi' => 'Proyektor untuk presentasi'],
                ['nama_item' => 'Komputer', 'deskripsi' => 'Komputer untuk pembelajaran'],
                ['nama_item' => 'AC', 'deskripsi' => 'Air Conditioner'],
                ['nama_item' => 'Lampu', 'deskripsi' => 'Lampu penerangan'],
                ['nama_item' => 'Kipas Angin', 'deskripsi' => 'Kipas angin untuk sirkulasi udara'],
            ];
            
            $this->db->table('items')->insertBatch($defaultItems);
            
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Inserted ' . count($defaultItems) . ' default items');
            }
        }
    }

    public function down()
    {
        // Clean up seeded data (optional - only for testing)
        $this->db->query("DELETE FROM user WHERE username = 'admin'");
        $this->db->query("DELETE FROM lokasi WHERE nama_lokasi IN ('Ruang Kelas 1', 'Ruang Kelas 2', 'Ruang Kelas 3', 'Laboratorium Komputer', 'Laboratorium IPA', 'Perpustakaan', 'Kantin', 'Toilet Siswa', 'Ruang Guru', 'Ruang Kepala Sekolah')");
        $this->db->query("DELETE FROM items WHERE nama_item IN ('Meja', 'Kursi', 'Papan Tulis', 'Proyektor', 'Komputer', 'AC', 'Lampu', 'Kipas Angin')");
        
        if (function_exists('log_message')) {
            log_message('info', '[MIGRATION] Cleaned up seeded data');
        }
    }
}
