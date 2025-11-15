<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBeforeAfterPhotosToPengaduan extends Migration
{
    public function up()
    {
        $fields = [
            'foto_before' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'foto'
            ],
            'foto_after' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'foto_before'
            ],
        ];

        $this->forge->addColumn('pengaduan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pengaduan', ['foto_before', 'foto_after']);
    }
}
