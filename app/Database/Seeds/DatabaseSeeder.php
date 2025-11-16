<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Run seeders in order
        $this->call('App\\Database\\Seeds\\UsersSeeder');
        $this->call('App\\Database\\Seeds\\LokasiSeeder');
        $this->call('App\\Database\\Seeds\\ItemsSeeder');
    }
}
