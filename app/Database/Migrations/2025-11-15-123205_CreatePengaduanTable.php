<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaduanTable extends Migration
{
    public function up()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'pengaduan'");
        if ($query->getNumRows() == 0) {
            $fields = [
                'id_pengaduan' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => false,
                    'auto_increment' => true,
                ],
                'id_temporary' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'id_lokasi' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'nama_pengaduan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 200,
                ],
                'deskripsi' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'lokasi' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 200,
                    'null'       => true,
                ],
                'foto' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 200,
                    'null'       => true,
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['Diajukan', 'Disetujui', 'Ditolak', 'Diproses', 'Selesai'],
                    'default'    => 'Diajukan',
                ],
                'id_user' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'id_petugas' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'id_item' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'tgl_pengajuan' => [
                    'type' => 'DATETIME',
                    'null' => true, // no default to avoid strict mode invalid default errors
                ],
                'tgl_selesai' => [
                    'type' => 'DATE',
                    'null' => true,
                ],
                'saran_petugas' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'foto_balasan' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'alasan_penolakan' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'foto_before' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'foto_after' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
            ];

            $this->forge->addField($fields);
            $this->forge->addKey('id_pengaduan', true);
            $this->forge->addKey('id_temporary');
            $this->forge->addKey('id_user');
            $this->forge->addKey('id_petugas');
            $this->forge->addKey('id_item');
            $this->forge->createTable('pengaduan');

            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Created pengaduan table successfully');
            }
        } else {
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] pengaduan table already exists, skipping creation');
            }
        }
    }

    public function down()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'pengaduan'");
        if ($query->getNumRows() > 0) {
            $this->forge->dropTable('pengaduan');
            if (function_exists('log_message')) {
                log_message('info', '[MIGRATION] Dropped pengaduan table');
            }
        }
    }
}
