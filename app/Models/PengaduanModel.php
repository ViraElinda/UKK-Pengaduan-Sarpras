<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaduanModel extends Model
{
    protected $table = 'pengaduan';
    protected $primaryKey = 'id_pengaduan';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nama_pengaduan', 'deskripsi', 'lokasi', 'foto',
        'status', 'id_user', 'id_petugas', 'id_item',
        'tgl_pengajuan', 'tgl_selesai', 'saran_petugas'
    ];

    protected $useTimestamps = false;
    protected $skipValidation = true;

    public function getAllWithUser()
    {
        return $this->select('pengaduan.*, user.nama_pengguna')
                    ->join('user', 'user.id_user = pengaduan.id_user', 'left')
                    ->orderBy('tgl_pengajuan', 'DESC')
                    ->findAll();
    }
}
