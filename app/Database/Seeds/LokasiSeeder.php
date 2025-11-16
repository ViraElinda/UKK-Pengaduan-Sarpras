<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LokasiSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $count = $db->table('lokasi')->countAllResults();
        if ($count > 0) return;

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

        $db->table('lokasi')->insertBatch($defaultLokasi);
    }
}
