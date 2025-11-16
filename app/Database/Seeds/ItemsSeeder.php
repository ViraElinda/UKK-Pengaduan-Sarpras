<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ItemsSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $count = $db->table('items')->countAllResults();
        if ($count > 0) return;

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

        $db->table('items')->insertBatch($defaultItems);
    }
}
