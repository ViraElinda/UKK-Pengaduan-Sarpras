<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\UserModel;
use App\Models\ItemModel;

class DashboardController extends BaseController
{
    protected $pengaduanModel;
    protected $userModel;
    protected $itemModel;

    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
        $this->userModel      = new UserModel();
        $this->itemModel      = new ItemModel();
    }

public function admin()
{
    if (session('role') !== 'admin') {
        return redirect()->to('/auth/unauthorized');
    }

    $username = session('username');

    $pengaduanModel = $this->pengaduanModel;
    $userModel      = $this->userModel;
    $itemModel      = $this->itemModel;

    // Statistik
    $aduan_ditolak   = $pengaduanModel->where('status', 'ditolak')->countAllResults();
    $aduan_diajukan  = $pengaduanModel->where('status', 'diajukan')->countAllResults();
    $aduan_disetujui = $pengaduanModel->where('status', 'disetujui')->countAllResults();
    $aduan_diproses  = $pengaduanModel->where('status', 'diproses')->countAllResults();
    $aduan_selesai   = $pengaduanModel->where('status', 'selesai')->countAllResults();

    // Pengaduan 7 hari terakhir
    $tanggal_harian = [];
    $jumlah_harian = [];
    for ($i = 6; $i >= 0; $i--) {
        $tanggal = date('Y-m-d', strtotime("-$i days"));
        $tanggal_harian[] = date('d M', strtotime($tanggal));

        $count = $pengaduanModel->where('DATE(tgl_pengajuan)', $tanggal)->countAllResults();
        $jumlah_harian[] = $count;
    }

    // 5 pengaduan terbaru (join user agar tampil nama pelapor langsung)
    $laporan_terbaru = $pengaduanModel
        ->select('pengaduan.*, user.nama_pengguna')
        ->join('user', 'pengaduan.id_user = user.id_user', 'left')
        ->orderBy('tgl_pengajuan', 'DESC')
        ->limit(5)
        ->findAll();

    $data = [
        'username'        => $username,
        'total_aduan'     => $pengaduanModel->countAll(),
        'total_user'      => $userModel->countAll(),
        'total_item'      => $itemModel->countAll(),
        'aduan_ditolak'   => $aduan_ditolak,
        'aduan_diajukan'  => $aduan_diajukan,
        'aduan_disetujui' => $aduan_disetujui,
        'aduan_diproses'  => $aduan_diproses,
        'aduan_selesai'   => $aduan_selesai,
        'tanggal_harian'  => json_encode($tanggal_harian),
        'jumlah_harian'   => json_encode($jumlah_harian),
        'laporan_terbaru' => $laporan_terbaru,
    ];

    return view('dashboard/admin', $data);
}

    /* ==========================
       DASHBOARD UNTUK PETUGAS
    =========================== */
    public function petugas()
    {
        if (session('role') !== 'petugas') {
            return redirect()->to('/auth/unauthorized');
        }

        $username = session('username');
        $idPetugas = session('id_petugas');

        // Ambil SEMUA pengaduan (bukan hanya yang ditugaskan)
        $pengaduan = $this->pengaduanModel->findAll();

        // Statistik pengaduan SEMUA
        $total_aduan = $this->pengaduanModel->countAll();
        $total_diajukan = $this->pengaduanModel->where('status', 'Diajukan')->countAllResults();
        $total_disetujui = $this->pengaduanModel->where('status', 'Disetujui')->countAllResults();
        $total_diproses = $this->pengaduanModel->where('status', 'Diproses')->countAllResults();
        $total_selesai = $this->pengaduanModel->where('status', 'Selesai')->countAllResults();
        $total_ditolak = $this->pengaduanModel->where('status', 'Ditolak')->countAllResults();

        // Pengaduan terbaru (5 terakhir)
        $pengaduan_terbaru = $this->pengaduanModel
            ->select('pengaduan.*, user.nama_pengguna')
            ->join('user', 'pengaduan.id_user = user.id_user', 'left')
            ->orderBy('pengaduan.tgl_pengajuan', 'DESC')
            ->limit(5)
            ->findAll();

        $data = [
            'username'  => $username,
            'pengaduan' => $pengaduan,
            'total_aduan' => $total_aduan,
            'total_diajukan' => $total_diajukan,
            'total_disetujui' => $total_disetujui,
            'total_diproses' => $total_diproses,
            'total_selesai' => $total_selesai,
            'total_ditolak' => $total_ditolak,
            'pengaduan_terbaru' => $pengaduan_terbaru,
        ];

        return view('dashboard/petugas', $data);
    }

    /* ==========================
       DASHBOARD UNTUK USER
    =========================== */
    public function user()
    {
        if (session('role') !== 'user') {
            return redirect()->to('/auth/unauthorized');
        }

        $username = session('username');

        // Ambil pengaduan milik user ini
        $idUser = session('id_user');
        $pengaduan = $this->pengaduanModel->where('id_user', $idUser)->findAll();

        $data = [
            'username'  => $username,
            'pengaduan' => $pengaduan,
        ];

        return view('dashboard/siswa', $data);
    }
}
