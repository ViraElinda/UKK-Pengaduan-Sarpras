<?php

namespace App\Controllers\Admin;

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
            $this->userModel = new UserModel();
            $this->itemModel = new ItemModel();
            date_default_timezone_set('Asia/Jakarta');
        }

    public function index()
    {
        $role = session('role');
        $username = session('username');

        if (!in_array($role, ['admin', 'petugas'])) {
            return view('errors/html/error_403');
        }

        // ambil data pengaduan
        if ($role === 'petugas') {
            $idPetugas = session('id_petugas');
            $pengaduan = $this->pengaduanModel->getByPetugas($idPetugas);
        } else {
            $pengaduan = $this->pengaduanModel->getAllWithUser();
        }

        // === STATISTIK ===
        $aduan_ditolak   = $this->pengaduanModel->where('status', 'Ditolak')->countAllResults(false);
        $aduan_diajukan  = $this->pengaduanModel->where('status', 'Diajukan')->countAllResults(false);
        $aduan_disetujui = $this->pengaduanModel->where('status', 'Disetujui')->countAllResults(false);
        $aduan_diproses  = $this->pengaduanModel->where('status', 'Diproses')->countAllResults(false);
        $aduan_selesai   = $this->pengaduanModel->where('status', 'Selesai')->countAllResults(false);

        $laporan_terbaru = $this->pengaduanModel
        ->orderBy('tgl_pengajuan', 'DESC')
        ->findAll(5);

        $data = [
        'aduan_ditolak'   => $aduan_ditolak,
        'aduan_diajukan'  => $aduan_diajukan,
        'aduan_disetujui' => $aduan_disetujui,
        'aduan_diproses'  => $aduan_diproses,
        'aduan_selesai'   => $aduan_selesai,
        'username'        => $username,
        'pengaduan'       => $pengaduan,
        'laporan_terbaru' => $laporan_terbaru    // ⬅ DITAMBAHKAN
    ];

        return view('dashboard/admin', $data);
    }


        public function store()
        {
            $role = session('role');
            if (!in_array($role, ['admin', 'petugas'])) {
                return view('errors/html/error_403');
            }

            $fotoFile = $this->request->getFile('foto');
            $fotoName = null;

            if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
                $fotoName = 'foto_' . time() . '.' . $fotoFile->getExtension();
                $fotoFile->move(FCPATH . 'uploads/foto_pengaduan/', $fotoName);
            }

            $this->pengaduanModel->insert([
                'nama_pengaduan' => $this->request->getPost('nama_pengaduan'),
                'deskripsi'      => $this->request->getPost('deskripsi'),
                'lokasi'         => $this->request->getPost('lokasi'),
                'foto'           => $fotoName,
                'status'         => $this->request->getPost('status') ?: 'Menunggu',
                'id_user'        => $this->request->getPost('id_user'),
                'id_item'        => $this->request->getPost('id_item') ?: null,
                'id_petugas'     => session('id_petugas') ?: null,
                'tgl_pengajuan'  => date('Y-m-d H:i:s'),
                'tgl_selesai'    => $this->request->getPost('tgl_selesai') ?: null,
                'saran_petugas'  => $this->request->getPost('saran_petugas') ?: null,
            ]);

            return redirect()->to('/admin/pengaduan')->with('success', 'Pengaduan berhasil ditambahkan.');
        }

    public function edit($id_pengaduan)
    {
        $role = session('role');
        if (!in_array($role, ['admin', 'petugas'])) {
            return view('errors/html/error_403');
        }

        $data = [
            'pengaduan' => $this->pengaduanModel->find($id_pengaduan),
            'users'     => $this->userModel->findAll(),
            'items'     => $this->itemModel->findAll(),
            'username'  => session('username'),
            'role'      => $role
        ];

        return view('admin/pengaduan/edit', $data);
    }

    public function update($id)
    {
        $role = session('role');
        if (!in_array($role, ['admin', 'petugas'])) {
            return view('errors/html/error_403');
        }

        $dataUpdate = [
            'nama_pengaduan' => $this->request->getPost('nama_pengaduan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'lokasi'         => $this->request->getPost('lokasi'),
            'status'         => $this->request->getPost('status'),
            'id_user'        => $this->request->getPost('id_user'),
            'id_item'        => $this->request->getPost('id_item') ?: null,
            'tgl_selesai'    => ($this->request->getPost('status') === 'Selesai') ? date('Y-m-d') : null,
            'saran_petugas'  => $this->request->getPost('saran_petugas') ?: null,
            'id_petugas'     => session('id_petugas') ?: null
        ];

        // Update foto jika ada
        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $fotoName = 'foto_' . time() . '.' . $fotoFile->getExtension();
            $fotoFile->move(FCPATH . 'uploads/foto_pengaduan/', $fotoName);
            $dataUpdate['foto'] = $fotoName;
        }

        $this->pengaduanModel->update($id, $dataUpdate);

        return redirect()->to('/admin/pengaduan')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $role = session('role');
        if (!in_array($role, ['admin', 'petugas'])) {
            return view('errors/html/error_403');
        }

        $this->pengaduanModel->delete($id);
        return redirect()->to('/admin/pengaduan')->with('success', 'Pengaduan berhasil dihapus.');
    }
}
