<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PengaduanModel;
use App\Models\UserModel;
use App\Models\ItemModel;
use App\Models\SarprasModel;

class DashboardController extends BaseController
{
public function admin()
{
    if (session('role') !== 'admin') {
        return redirect()->to('/auth/unauthorized');
    }

    $username = session('username');

    $pengaduanModel = new PengaduanModel();
    $userModel      = new UserModel();
    $itemModel      = new ItemModel();

    $pengaduan = $pengaduanModel->findAll(); // ambil semua data pengaduan

    $data = [
        'username'      => $username,
        'pengaduan'     => $pengaduan,           // kirim ke view
        'total_aduan'   => $pengaduanModel->countAllResults(),
        'total_user'    => $userModel->countAllResults(),
        'total_item'    => $itemModel->countAllResults(),
        'dashboardUrl'  => base_url('dashboard/admin')
    ];

    return view('dashboard/admin', $data);
}

    public function petugas()
    {
        if (session('role') !== 'petugas') {
            return redirect()->to('/auth/unauthorized');
        }

        $username = session('username');
        return view('dashboard/petugas', ['username' => $username]);
    }

    public function guru()
    {
        if (session('role') !== 'guru') {
            return redirect()->to('/auth/unauthorized');
        }

        $username = session('username');
        return view('dashboard/guru', ['username' => $username]);
    }

    public function siswa()
    {
        if (session('role') !== 'siswa') {
            return redirect()->to('/auth/unauthorized');
        }

        $username = session('username');
        return view('dashboard/siswa', ['username' => $username]);
    }
}
