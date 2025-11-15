<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaduanModel extends Model
{
    protected $table            = 'pengaduan';
    protected $primaryKey       = 'id_pengaduan';

    protected $allowedFields = [
        'nama_pengaduan',
        'deskripsi',
        'lokasi',
        'id_lokasi',
        'id_item',
        'id_temporary',
        'foto',
        'foto_balasan',
        'foto_before',
        'foto_after',
        'foto_url',
        'status',
        'id_user',
        'id_petugas',
        'tgl_pengajuan',
        'alasan_penolakan',
        'saran_petugas',
        'tgl_selesai',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ===========================
    // JOIN PETUGAS
    // ===========================
    public function getAllWithPetugas()
    {
        return $this->select('pengaduan.*, petugas.nama AS nama_petugas')
                    ->join('petugas', 'pengaduan.id_petugas = petugas.id_petugas', 'left')
                    ->orderBy('pengaduan.id_pengaduan', 'DESC')
                    ->findAll();
    }

    // ===========================
    // JOIN USER & PETUGAS
    // ===========================
    public function getAllWithUser()
    {
        return $this->select('pengaduan.*, user.nama_pengguna AS nama_user, petugas.nama AS nama_petugas')
                    ->join('user', 'pengaduan.id_user = user.id_user', 'left')
                    ->join('petugas', 'pengaduan.id_petugas = petugas.id_petugas', 'left')
                    ->orderBy('pengaduan.id_pengaduan', 'DESC')
                    ->findAll();
    }

    // ===========================
    // GET BY PETUGAS LOGIN
    // ===========================
    public function getByPetugas($idPetugas)
    {
        return $this->select('pengaduan.*, petugas.nama AS nama_petugas, user.nama_pengguna AS nama_user')
                    ->join('petugas', 'pengaduan.id_petugas = petugas.id_petugas', 'left')
                    ->join('user', 'pengaduan.id_user = user.id_user', 'left')
                    ->groupStart()
                        ->where('pengaduan.id_petugas', $idPetugas)
                        ->orWhere('pengaduan.id_petugas', null)
                    ->groupEnd()
                    ->orderBy('pengaduan.id_pengaduan', 'DESC')
                    ->findAll();
    }
}
