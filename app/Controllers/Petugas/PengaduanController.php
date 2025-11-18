<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\NotifModel;

class PengaduanController extends BaseController
{
    protected $pengaduanModel;

    public function __construct()
    {
        $this->pengaduanModel = new PengaduanModel();
    }

    /**
     * Tampilkan SEMUA pengaduan untuk petugas kelola
     */
    public function index()
    {
        $idPetugas = session('id_petugas');

        if (!$idPetugas) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil SEMUA pengaduan dengan join user untuk nama pelapor
        $data['pengaduan'] = $this->pengaduanModel
            ->select('pengaduan.*, user.nama_pengguna, lokasi.nama_lokasi')
            ->join('user', 'pengaduan.id_user = user.id_user', 'left')
            ->join('lokasi', 'pengaduan.id_lokasi = lokasi.id_lokasi', 'left')
            ->orderBy('pengaduan.tgl_pengajuan', 'DESC')
            ->findAll();
            
        return view('petugas/pengaduan/index', $data);
    }

    /**
     * Tampilkan form edit pengaduan
     */
    public function edit($id)
    {
        $pengaduan = $this->pengaduanModel->find($id);

        if (!$pengaduan) {
            return redirect()->to('/petugas/pengaduan')->with('error', 'Pengaduan tidak ditemukan.');
        }

        // VALIDASI: Jika status sudah Selesai, tidak boleh diubah
        if (strtolower($pengaduan['status']) === 'selesai') {
            return redirect()->to('/petugas/pengaduan')->with('error', 'Pengaduan sudah selesai dan tidak bisa diubah lagi.');
        }

        $data['pengaduan'] = $pengaduan;
        return view('petugas/pengaduan/edit', $data);
    }

    /**
     * Update status pengaduan (hanya untuk petugas)
     */
    public function update($id)
{
    // Pastikan petugas login
    $idPetugas = session('id_petugas');
    if (!$idPetugas) {
        // Jika session id_petugas tidak ada, coba resolve dari session id_user
        $userId = session('id_user');
        if ($userId && session('role') === 'petugas') {
            try {
                $db = \Config\Database::connect();
                $petugasRow = $db->table('petugas')->where('id_user', $userId)->get()->getRowArray();
                if ($petugasRow) {
                    $idPetugas = $petugasRow['id_petugas'];
                    session()->set('id_petugas', $idPetugas);
                } else {
                    // Jika belum ada record petugas, buat otomatis (safety: use username/nama_pengguna)
                    $userModel = new \App\Models\UserModel();
                    $user = $userModel->find($userId);
                    if ($user) {
                        $insert = [
                            'id_user' => $userId,
                            'nama'    => $user['nama_pengguna'] ?? $user['username'],
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        $db->table('petugas')->insert($insert);
                        $idPetugas = $db->insertID();
                        session()->set('id_petugas', $idPetugas);
                    }
                }
            } catch (\Throwable $e) {
                // ignore DB errors here; we'll handle missing idPetugas below
            }
        }

        if (!$idPetugas) {
            return redirect()->to('/auth/login')->with('error', 'Silakan login terlebih dahulu.');
        }
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
        if (!in_array('foto_balasan', $fields, true)) {
            $add['foto_balasan'] = ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true];
        }
        if (!empty($add)) {
            $forge->addColumn('pengaduan', $add);
        }
    } catch (\Throwable $e) {
        // ignore; we'll still try to proceed
    }

    // Ambil data pengaduan saat ini untuk validasi & penghapusan file lama
    $current = $this->pengaduanModel->find($id);
    if (!$current) {
        return redirect()->to('/petugas/pengaduan')->with('error', 'Pengaduan tidak ditemukan.');
    }

    // VALIDASI: Jika status sudah Selesai, tidak boleh diubah
    if (strtolower($current['status']) === 'selesai') {
        return redirect()->to('/petugas/pengaduan')->with('error', 'Pengaduan sudah selesai dan tidak bisa diubah lagi.');
    }

    $postData = $this->request->getPost([
        'status',
        'saran_petugas',
        'alasan_penolakan'
    ]);

    // Jika status bukan Ditolak → hapus alasan
    if ($postData['status'] !== 'Ditolak') {
        $postData['alasan_penolakan'] = null;
    }

    // Set id_petugas agar tercatat siapa yang menangani
    $postData['id_petugas'] = $idPetugas;

    // Handle foto_balasan (foto balasan dari petugas)
    $fotoBalasan = $this->request->getFile('foto_balasan');

    $updateFiles = [];

    // Prepare upload directory
    $balasanDir = FCPATH . 'uploads/foto_balasan/';
    if (!is_dir($balasanDir)) { @mkdir($balasanDir, 0755, true); }

    // ===== Server-side validations =====
    $errors = [];
    $allowedExt = ['jpg','jpeg','png','webp'];
    $maxBytes = 3 * 1024 * 1024; // 3MB (changed from 5MB to enforce smaller balasan uploads)

    // Enforce Foto Balasan is required when petugas mengelola pengaduan
    if (!($fotoBalasan && $fotoBalasan->getName() !== '' && $fotoBalasan->isValid() && !$fotoBalasan->hasMoved())) {
        $errors[] = 'Foto Balasan wajib diunggah saat mengelola pengaduan.';
    } else {
        // Validate Foto Balasan when provided
        if ($fotoBalasan && $fotoBalasan->getName() !== '' && $fotoBalasan->isValid() && !$fotoBalasan->hasMoved()) {
        $ext = strtolower($fotoBalasan->getExtension());
        if (!in_array($ext, $allowedExt, true)) {
            $errors[] = 'Format Foto Balasan harus jpg, jpeg, png, atau webp.';
        }
        if ($fotoBalasan->getSize() > $maxBytes) {
            $errors[] = 'Ukuran Foto Balasan maksimal 3MB.';
        }
        }
    }

    if (!empty($errors)) {
        return redirect()->back()->withInput()->with('error', implode(' ', $errors));
    }

    // Process Foto Balasan
    if ($fotoBalasan && $fotoBalasan->isValid() && !$fotoBalasan->hasMoved()) {
        try {
            $ext = $fotoBalasan->getExtension();
            $name = 'balasan_' . $id . '_' . time() . '.' . $ext;
            // Remove old file if exists
            if (!empty($current['foto_balasan'])) {
                $old = $balasanDir . $current['foto_balasan'];
                if (is_file($old)) { @unlink($old); }
            }
            $fotoBalasan->move($balasanDir, $name);

            \Config\Services::image()
                ->withFile($balasanDir . $name)
                ->resize(1280, 1280, true, 'auto')
                ->save($balasanDir . $name, 75);

            $updateFiles['foto_balasan'] = $name;
        } catch (\Throwable $e) {
            // ignore image errors silently but do not block status update
        }
    }

    // Auto set tgl_selesai if status becomes Selesai
    if ($postData['status'] === 'Selesai') {
        $postData['tgl_selesai'] = date('Y-m-d H:i:s');
    }

    $this->pengaduanModel->update($id, array_merge($postData, $updateFiles));

    // Kirim notifikasi ke user pemilik pengaduan bahwa statusnya berubah
    try {
        $notifModel = new NotifModel();
        $userId = $current['id_user'] ?? null;
        if ($userId) {
            $judul = 'Status Pengaduan Diperbarui';
            $pesan = 'Status pengaduan "' . ($current['nama_pengaduan'] ?? 'Pengaduan') . '" telah diubah menjadi ' . ($postData['status'] ?? '') . '.';
            // Link ke halaman detail user (relative)
            $link = 'user/pengaduan/' . $id;
            $notifModel->createNotif($userId, $judul, $pesan, 'info', $link);
        }
    } catch (\Throwable $e) {
        if (function_exists('log_message')) {
            log_message('error', '[Notif] Failed to create notif on petugas update: ' . $e->getMessage());
        }
    }

    return redirect()->to('/petugas/pengaduan')->with('success', 'Status pengaduan diperbarui.');
}

}
