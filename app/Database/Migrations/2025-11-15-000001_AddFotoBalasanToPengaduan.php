<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoBalasanToPengaduan extends Migration
{
    public function up()
    {
        $fields = [
            'foto_balasan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'saran_petugas'
            ],
        ];

        $this->forge->addColumn('pengaduan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pengaduan', ['foto_balasan']);
    }
}
