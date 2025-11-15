<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\UserModel;
use App\Models\ItemModel;
use App\Models\LokasiModel;
use App\Models\NotifModel;

class PengaduanController extends BaseController
{
    protected $pengaduanModel;
    protected $userModel;
    protected $itemModel;
    protected $lokasiModel;
    protected $notifModel;

    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
        $this->userModel = new UserModel();
        $this->itemModel = new ItemModel();
        $this->lokasiModel = new LokasiModel();
        $this->notifModel = new NotifModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $role = session('role');

        if (!in_array($role, ['admin', 'petugas'])) {
            return view('errors/html/error_403');
        }

        // jika petugas, tampilkan hanya pengaduan yang ditugaskan ke dia
        if ($role === 'petugas') {
            $idPetugas = session('id_petugas');
            $pengaduan = $this->pengaduanModel->getByPetugas($idPetugas);
        } else {
            $pengaduan = $this->pengaduanModel->getAllWithUser();
        }

        $data = [
            'pengaduan'    => $pengaduan,
            'total_aduan'  => $this->pengaduanModel->countAllResults(),
            'total_user'   => $this->userModel->countAllResults(),
            'total_item'   => $this->itemModel->countAllResults(),
            'username'     => session('username'),
            'role'         => $role
        ];

        return view('admin/pengaduan/index', $data);
    }

    public function create()
    {
        $role = session('role');
        if (!in_array($role, ['admin', 'petugas'])) {
            return view('errors/html/error_403');
        }

        $data = [
            'users'     => $this->userModel->findAll(),
            'items'     => $this->itemModel->findAll(),
                'lokasi'    => $this->lokasiModel->findAll(),
            'username'  => session('username'),
        ];

        return view('admin/pengaduan/create', $data);
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

        // Lokasi handling: prefer id_lokasi, fallback to lokasi text
        $idLokasiPost = $this->request->getPost('id_lokasi');
        $lokasiTextPost = trim((string) $this->request->getPost('lokasi'));
        $idLokasi = null;
        $lokasiText = null;

        if (!empty($idLokasiPost)) {
            $rowLok = $this->lokasiModel->find($idLokasiPost);
            if ($rowLok) {
                $idLokasi = (int) $idLokasiPost;
                $lokasiText = $rowLok['nama_lokasi'];
            }
        }
        if (empty($lokasiText) && $lokasiTextPost !== '') {
            $lokasiText = $lokasiTextPost;
        }

        $status = $this->request->getPost('status');
        $idItem = $this->request->getPost('id_item') ?: null;

        // Check for duplicate active complaint (same location & item)
        if ($idLokasi && $idItem) {
            $existingComplaint = $this->pengaduanModel
                ->where('id_lokasi', $idLokasi)
                ->where('id_item', $idItem)
                ->where('status !=', 'Selesai')
                ->first();
            
            if ($existingComplaint) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pengaduan untuk lokasi & item ini masih aktif, tidak dapat mengajukan lagi.');
            }
        }

        $dataInsert = [
            'nama_pengaduan' => $this->request->getPost('nama_pengaduan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'id_lokasi'      => $idLokasi,
            'lokasi'         => $lokasiText,
            'foto'           => $fotoName,
            'status'         => $status,
            'id_user'        => $this->request->getPost('id_user'),
            'id_item'        => $idItem,
            'id_petugas'     => session('id_petugas') ?: null,
            'tgl_pengajuan'  => date('Y-m-d H:i:s'),
            'tgl_selesai'    => $this->request->getPost('tgl_selesai') ?: null,
        ];

        // Tambahkan alasan penolakan jika status Ditolak
        if ($status === 'Ditolak') {
            $dataInsert['alasan_penolakan'] = $this->request->getPost('alasan_penolakan') ?: null;
        }

        $this->pengaduanModel->insert($dataInsert);

        return redirect()->to('/admin/pengaduan')->with('success', 'Pengaduan berhasil ditambahkan.');
    }

    public function edit($id_pengaduan)
    {
        $role = session('role');
        if (!in_array($role, ['admin', 'petugas'])) {
            return view('errors/html/error_403');
        }

        $pengaduan = $this->pengaduanModel->find($id_pengaduan);
        
        // Validasi: Jika status sudah Selesai, redirect dengan pesan error
        if ($pengaduan && strtolower($pengaduan['status']) === 'selesai') {
            return redirect()->to('/admin/pengaduan')->with('error', 'Pengaduan sudah selesai dan tidak bisa diubah lagi.');
        }

        // Validasi: Jika petugas sudah MEMPROSES (Diproses, Disetujui, Ditolak) dan yang akses adalah admin, redirect
        if ($role === 'admin' && $pengaduan && in_array(strtolower($pengaduan['status']), ['diproses', 'disetujui', 'ditolak'])) {
            return redirect()->to('/admin/pengaduan')->with('error', 'Pengaduan sudah diproses oleh petugas. Admin tidak bisa mengubah status lagi.');
        }

        $data = [
            'pengaduan' => $pengaduan,
            'users'     => $this->userModel->findAll(),
            'items'     => $this->itemModel->findAll(),
                'lokasi'    => $this->lokasiModel->findAll(),
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

        // Pastikan kolom before/after tersedia (fallback jika migrasi belum jalan)
        try {
            $db = \Config\Database::connect();
            $forge = \Config\Database::forge();
            $fields = array_map('strtolower', $db->getFieldNames('pengaduan'));
            $add = [];
            if (!in_array('foto_before', $fields, true)) {
                $add['foto_before'] = ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true];
            }
            if (!in_array('foto_after', $fields, true)) {
                $add['foto_after'] = ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true];
            }
            if (!empty($add)) {
                $forge->addColumn('pengaduan', $add);
            }
        } catch (\Throwable $e) {
            // ignore; we'll still try to proceed
        }

        // Ambil data pengaduan saat ini
        $current = $this->pengaduanModel->find($id);
        if (!$current) {
            return redirect()->to('/admin/pengaduan')->with('error', 'Pengaduan tidak ditemukan.');
        }

        // VALIDASI: Jika status sudah Selesai, tidak boleh diubah
        if (strtolower($current['status']) === 'selesai') {
            return redirect()->to('/admin/pengaduan')->with('error', 'Pengaduan sudah selesai dan tidak bisa diubah lagi.');
        }

        // VALIDASI: Jika petugas sudah MEMPROSES dan yang akses adalah admin, tidak boleh diubah
        if ($role === 'admin' && in_array(strtolower($current['status']), ['diproses', 'disetujui', 'ditolak'])) {
            return redirect()->to('/admin/pengaduan')->with('error', 'Pengaduan sudah diproses oleh petugas. Admin tidak bisa mengubah status lagi.');
        }

        // Lokasi handling for update
        $idLokasiPost = $this->request->getPost('id_lokasi');
        $lokasiTextPost = trim((string) $this->request->getPost('lokasi'));
        $idLokasi = null;
        $lokasiText = null;

        if (!empty($idLokasiPost)) {
            $rowLok = $this->lokasiModel->find($idLokasiPost);
            if ($rowLok) {
                $idLokasi = (int) $idLokasiPost;
                $lokasiText = $rowLok['nama_lokasi'];
            }
        }
        if (empty($lokasiText) && $lokasiTextPost !== '') {
            $lokasiText = $lokasiTextPost;
        }

        $status = $this->request->getPost('status');

        $dataUpdate = [
            'nama_pengaduan' => $this->request->getPost('nama_pengaduan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'id_lokasi'      => $idLokasi,
            'lokasi'         => $lokasiText,
            'status'         => $status,
            'id_user'        => $this->request->getPost('id_user'),
            'id_item'        => $this->request->getPost('id_item') ?: null,
            'tgl_selesai'    => ($status === 'Selesai') ? date('Y-m-d') : null,
            'id_petugas'     => session('id_petugas') ?: null
        ];

        // Tambahkan alasan penolakan jika status Ditolak
        if ($status === 'Ditolak') {
            $dataUpdate['alasan_penolakan'] = $this->request->getPost('alasan_penolakan') ?: null;
        }

        // ===== Upload utama (foto laporan awal) =====
        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $fotoName = 'foto_' . time() . '.' . $fotoFile->getExtension();
            $fotoFile->move(FCPATH . 'uploads/foto_pengaduan/', $fotoName);
            $dataUpdate['foto'] = $fotoName;
        }

        // Admin tidak perlu upload foto before/after
        // Foto balasan hanya dari petugas
        
        $this->pengaduanModel->update($id, $dataUpdate);

        // Jika status berubah, kirim notifikasi ke pemilik pengaduan (safety-wrapped)
        try {
            $oldStatus = strtolower($current['status'] ?? '');
            $newStatus = strtolower($status ?? '');
            if ($newStatus !== $oldStatus) {
                // Tentukan recipient: gunakan id_user dari form jika ada, fallback ke current
                $recipient = $dataUpdate['id_user'] ?? $current['id_user'];
                if (!empty($recipient)) {
                    $judul = 'Status pengaduan Anda: ' . ($dataUpdate['status'] ?? $current['status']);
                    $namaPengaduan = $dataUpdate['nama_pengaduan'] ?? $current['nama_pengaduan'] ?? '';
                    $pesan = 'Pengaduan "' . $namaPengaduan . '" telah berubah menjadi ' . ($dataUpdate['status'] ?? $current['status']) . '.';
                    $link = 'user/pengaduan/detail/' . $id;
                    // createNotif handles insertion; wrap to avoid fatal errors if table missing
                    $this->notifModel->createNotif($recipient, $judul, $pesan, 'info', $link);
                }
            }
        } catch (\Throwable $e) {
            // Jika tabel notif belum ada atau error lain, jangan ganggu alur update
            // Log error supaya mudah di-troubleshoot
            if (function_exists('log_message')) {
                log_message('error', '[Notif] Gagal membuat notifikasi: ' . $e->getMessage());
            }
        }

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
