<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotifModel;

class NotifController extends BaseController
{
    protected $notifModel;

    public function __construct()
    {
        $this->notifModel = new NotifModel();
    }

    /**
     * Get notifikasi untuk user login (AJAX)
     */
    public function getNotifications()
    {
        $idUser = session('id_user');
        
        if (!$idUser) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User tidak terautentikasi',
                'notifications' => [],
                'unread_count' => 0
            ]);
        }

        try {
            $notifikasi = $this->notifModel->getByUser($idUser, 10);
            $unreadCount = $this->notifModel->countUnread($idUser);

            return $this->response->setJSON([
                'success' => true,
                'notifications' => $notifikasi,
                'unread_count' => $unreadCount
            ]);
        } catch (\Throwable $e) {
            // If the notif table is missing or DB fails, log and return a safe empty response
            if (function_exists('log_message')) {
                log_message('error', '[Notif] getNotifications failed: ' . $e->getMessage());
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memuat notifikasi (server).',
                'notifications' => [],
                'unread_count' => 0
            ])->setStatusCode(200);
        }
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead($idNotif)
    {
        $this->notifModel->markAsRead($idNotif);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Notifikasi ditandai sebagai sudah dibaca'
        ]);
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        $idUser = session('id_user');
        $this->notifModel->markAllAsRead($idUser);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sebagai sudah dibaca'
        ]);
    }

    /**
     * Hapus notifikasi
     */
    public function delete($idNotif)
    {
        $this->notifModel->delete($idNotif);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus'
        ]);
    }

    /**
     * Halaman daftar notifikasi
     */
    public function index()
    {
        $idUser = session('id_user');
        $role = session('role');

        // Mark notifications as read when user visits the "lihat semua notifikasi" page
        // This makes the dashboard/navbar badge clear immediately for this user.
        try {
            if ($idUser) {
                $this->notifModel->markAllAsRead($idUser);
            }
        } catch (\Throwable $e) {
            // don't break the page if DB/table isn't available; just log
            if (function_exists('log_message')) {
                log_message('error', '[Notif] markAllAsRead failed on index view: ' . $e->getMessage());
            }
        }

        // Fetch notifications for the list page; protect against DB errors so page still loads
        try {
            $notifications = $this->notifModel->getByUser($idUser, 50);
            $unread = $this->notifModel->countUnread($idUser);
        } catch (\Throwable $e) {
            if (function_exists('log_message')) {
                log_message('error', '[Notif] getByUser/countUnread failed on index view: ' . $e->getMessage());
            }
            $notifications = [];
            $unread = 0;
        }

        $data = [
            'notifikasi' => $notifications,
            'unread_count' => $unread,
        ];

        // Load view sesuai role
        $layout = ($role === 'user') ? 'layout/main' : 'layout/admin';
        
        return view('notif/index', $data);
    }
}
