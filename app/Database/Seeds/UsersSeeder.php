<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $count = $db->table('user')->where('role', 'admin')->countAllResults();
        if ($count > 0) {
            return; // already seeded
        }

        $data = [
            'username'      => 'admin',
            'password'      => password_hash('admin123', PASSWORD_DEFAULT),
            'nama_pengguna' => 'Administrator',
            'role'          => 'admin',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        $db->table('user')->insert($data);
    }
}
