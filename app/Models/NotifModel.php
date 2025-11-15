<?php

namespace App\Models;

use CodeIgniter\Model;

class NotifModel extends Model
{
    protected $table      = 'notif';
    protected $primaryKey = 'id_notif';
    protected $allowedFields = ['id_user', 'judul', 'pesan', 'tipe', 'is_read', 'link', 'created_at'];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    /**
     * Buat notifikasi baru
     */
    public function createNotif($idUser, $judul, $pesan, $tipe = 'info', $link = null)
    {
        return $this->insert([
            'id_user' => $idUser,
            'judul' => $judul,
            'pesan' => $pesan,
            'tipe' => $tipe,
            'link' => $link,
        ]);
    }

    /**
     * Ambil semua notifikasi user (belum dibaca di atas)
     */
    public function getByUser($idUser, $limit = 10)
    {
        return $this->where('id_user', $idUser)
                    ->orderBy('is_read', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Hitung notifikasi yang belum dibaca
     */
    public function countUnread($idUser)
    {
        return $this->where('id_user', $idUser)
                    ->where('is_read', 0)
                    ->countAllResults();
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead($idNotif)
    {
        return $this->update($idNotif, ['is_read' => 1]);
    }

    /**
     * Tandai semua notifikasi user sebagai sudah dibaca
     */
    public function markAllAsRead($idUser)
    {
        return $this->where('id_user', $idUser)
                    ->set(['is_read' => 1])
                    ->update();
    }

    /**
     * Hapus notifikasi lama (lebih dari 30 hari)
     */
    public function deleteOld($days = 30)
    {
        $date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        return $this->where('created_at <', $date)
                    ->where('is_read', 1)
                    ->delete();
    }

    /**
     * Kirim notifikasi ke semua admin
     */
    public function notifyAdmins($judul, $pesan, $tipe = 'info', $link = null)
    {
        $userModel = new \App\Models\UserModel();
        $admins = $userModel->where('role', 'admin')->findAll();

        foreach ($admins as $admin) {
            $this->createNotif($admin['id_user'], $judul, $pesan, $tipe, $link);
        }
    }

    /**
     * Kirim notifikasi ke semua petugas
     */
    public function notifyPetugas($judul, $pesan, $tipe = 'info', $link = null)
    {
        $userModel = new \App\Models\UserModel();
        $petugas = $userModel->where('role', 'petugas')->findAll();

        foreach ($petugas as $p) {
            $this->createNotif($p['id_user'], $judul, $pesan, $tipe, $link);
        }
    }
}
