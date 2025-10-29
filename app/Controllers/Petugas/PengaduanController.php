<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\UserModel;

class PengaduanController extends BaseController
{
    protected $pengaduanModel;
    protected $userModel;

    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
        $this->userModel = new UserModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        // Ambil semua pengaduan dengan data user
        $data['pengaduan'] = $this->pengaduanModel->getAllWithUser();
        return view('petugas/pengaduan/index', $data);
    }

    public function create()
    {
        $data['users'] = $this->userModel->findAll();
        return view('petugas/pengaduan/create', $data);
    }

    public function store()
    {
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
            'status'         => $this->request->getPost('status'),
            'id_user'        => $this->request->getPost('id_user'),
            'id_petugas'     => session()->get('id_user'), // otomatis petugas aktif
            'id_item'        => $this->request->getPost('id_item') ?: null,
            'tgl_pengajuan'  => date('Y-m-d H:i:s'),
            'tgl_selesai'    => $this->request->getPost('tgl_selesai') ?: null,
            'saran_petugas'  => $this->request->getPost('saran_petugas') ?: null,
        ]);

        return redirect()->to('/petugas/pengaduan')->with('success', 'Pengaduan berhasil ditambahkan.');
    }

    public function edit($id_pengaduan)
    {
        $pengaduan = $this->pengaduanModel->find($id_pengaduan);
        $users = $this->userModel->findAll();

        return view('petugas/pengaduan/edit', [
            'pengaduan' => $pengaduan,
            'users' => $users
        ]);
    }

    public function update($id)
    {
        $dataUpdate = [
            'nama_pengaduan' => $this->request->getPost('nama_pengaduan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'lokasi'         => $this->request->getPost('lokasi'),
            'status'         => $this->request->getPost('status'),
            'id_user'        => $this->request->getPost('id_user'),
            'id_petugas'     => session()->get('id_user'), // update otomatis ke petugas aktif
            'id_item'        => $this->request->getPost('id_item') ?: null,
            'tgl_selesai'    => $this->request->getPost('tgl_selesai') ?: null,
            'saran_petugas'  => $this->request->getPost('saran_petugas') ?: null,
        ];

        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $fotoName = 'foto_' . time() . '.' . $fotoFile->getExtension();
            $fotoFile->move(FCPATH . 'uploads/foto_pengaduan/', $fotoName);
            $dataUpdate['foto'] = $fotoName;
        }

        $this->pengaduanModel->update($id, $dataUpdate);

        return redirect()->to('/petugas/pengaduan')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->pengaduanModel->delete($id);
        return redirect()->to('/petugas/pengaduan')->with('success', 'Pengaduan berhasil dihapus.');
    }
}
