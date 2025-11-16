<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PengaduanModel;
use App\Models\NotifModel;
use App\Models\ItemModel;
use App\Models\ListLokasiModel;
use App\Models\LokasiModel;

class PengaduanController extends BaseController
{
    protected $pengaduanModel;
    protected $itemModel;
    protected $listLokasiModel;
    protected $lokasiModel;
    protected $db;

    public function __construct()
{
    $this->pengaduanModel   = new PengaduanModel();
    $this->itemModel        = new ItemModel();
    $this->listLokasiModel  = new ListLokasiModel();
    $this->lokasiModel      = new LokasiModel();
    
    $this->db = \Config\Database::connect(); // ✅ Fix
    
    date_default_timezone_set('Asia/Jakarta');
}

    public function index()
    {
        return view('user/pengaduan_form', [
            'lokasi' => $this->lokasiModel->findAll()
        ]);
    }

    public function getItems($id_lokasi)
    {
        // Validasi ID lokasi
        if (empty($id_lokasi) || !is_numeric($id_lokasi)) {
            return $this->response->setJSON([]);
        }

        // Query items berdasarkan lokasi
        $items = $this->listLokasiModel
            ->select('items.id_item, items.nama_item')
            ->join('items', 'items.id_item = list_lokasi.id_item', 'left')
            ->where('list_lokasi.id_lokasi', $id_lokasi)
            ->findAll();

        // Return JSON response
        return $this->response
            ->setContentType('application/json')
            ->setJSON($items ?: []);
    }


    public function store()
    {
        helper(['form', 'url']);

        $rules = [
            'nama_pengaduan' => 'required|max_length[255]',
            'deskripsi'      => 'required',
            'id_lokasi'      => 'required|integer',
            'id_item'        => 'permit_empty|integer',
            'item_baru'      => 'permit_empty|string',
            'foto'           => 'uploaded[foto]|is_image[foto]|max_size[foto,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
        }

        $idLokasi   = $this->request->getVar('id_lokasi');
        $idItem     = $this->request->getVar('id_item');
        $itemBaru   = trim($this->request->getVar('item_baru'));

    // Jika user mengisi "Item Baru", prioritaskan itu (abaikan pilihan dropdown)
    if (!empty($itemBaru)) {
        // Ambil nama lokasi dari ID
        $lokasi = $this->lokasiModel->find($idLokasi);
        $namaLokasi = $lokasi ? $lokasi['nama_lokasi'] : null;

        // Log untuk debugging
        log_message('info', "[ITEM_BARU] User input: '{$itemBaru}' di lokasi '{$namaLokasi}' (ID: {$idLokasi})");

        // Catat item baru di tabel temporary_item menggunakan NAMA lokasi
        $cekTemp = $this->db->table('temporary_item')
            ->where('nama_barang_baru', $itemBaru)
            ->where('lokasi_barang_baru', $namaLokasi)
            ->get()
            ->getFirstRow();

        if (!$cekTemp) {
            $insertResult = $this->db->table('temporary_item')->insert([
                'nama_barang_baru'   => $itemBaru,
                'lokasi_barang_baru' => $namaLokasi, // Simpan NAMA lokasi, bukan ID
                'status'             => 'pending'
            ]);
            $idTemp = $this->db->insertID();
            log_message('info', "[ITEM_BARU] Berhasil insert ke temporary_item dengan ID: {$idTemp}");
        } else {
            $idTemp = $cekTemp->id_temporary;
            log_message('info', "[ITEM_BARU] Item sudah ada di temporary_item dengan ID: {$idTemp}");
        }
        
        // Reset id_item karena kita pakai item baru
        $idItem = null;
    }

        // ==== HANDLE FOTO (WAJIB) ====
        $foto = $this->request->getFile('foto');
        $imgName = null;

        // Foto wajib ada karena sudah divalidasi di rules
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $imgName    = 'foto_' . time() . '.' . $foto->getExtension();
            $uploadPath = FCPATH . 'uploads/foto_pengaduan/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            try {
                $foto->move($uploadPath, $imgName);

                \Config\Services::image()
                    ->withFile($uploadPath . $imgName)
                    ->resize(800, 800, true, 'auto')
                    ->save($uploadPath . $imgName, 75);

            } catch (\Exception $e) {
                $imgName = null;
            }
        }

        // ==== SIMPAN ====
        // Ambil nama lokasi dari id_lokasi
        $lokasiData = $this->lokasiModel->find($idLokasi);
        $namaLokasiText = $lokasiData ? $lokasiData['nama_lokasi'] : null;

        // Check for duplicate active complaint (same location & item)
        if ($idLokasi && !empty($idItem)) {
            $existingComplaint = $this->pengaduanModel
                ->where('id_lokasi', $idLokasi)
                ->where('id_item', $idItem)
                ->where('status !=', 'Selesai')
                ->first();
            
            if ($existingComplaint) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pengaduan untuk lokasi & item ini masih aktif. Silakan tunggu hingga selesai sebelum mengajukan kembali.');
            }
        }

        $dataInsert = [
            'nama_pengaduan' => $this->request->getVar('nama_pengaduan'),
            'deskripsi'      => $this->request->getVar('deskripsi'),
            'id_lokasi'      => $idLokasi,
            'lokasi'         => $namaLokasiText,
            'foto'           => $imgName,
            'status'         => 'Diajukan',
            'id_user'        => session()->get('id_user'),
            'tgl_pengajuan'  => date('Y-m-d H:i:s'),
        ];

        // Simpan id_item jika dipilih (tidak kosong)
        if (!empty($idItem)) {
            $dataInsert['id_item'] = $idItem;
        }

        // Simpan id_temporary jika item baru
        if (isset($idTemp)) {
            $dataInsert['id_temporary'] = $idTemp;
        }

        $this->pengaduanModel->insert($dataInsert);
        // Kirim notifikasi ke admin dan petugas agar ada yang menindaklanjuti
        try {
            $notifModel = new NotifModel();
            $namaUser = session()->get('username') ?: 'Pengguna';
            $judul = 'Pengaduan baru dari ' . $namaUser;
            $pesan = 'Pengaduan "' . ($dataInsert['nama_pengaduan'] ?? '') . '" telah diajukan.';
            // Link yang diharapkan petugas/admin buka
            $link = 'admin/pengaduan';
            $notifModel->notifyAdmins($judul, $pesan, 'info', $link);
            $notifModel->notifyPetugas($judul, $pesan, 'info', $link);
        } catch (\Throwable $e) {
            if (function_exists('log_message')) {
                log_message('error', '[Notif] Gagal membuat notifikasi pengaduan baru: ' . $e->getMessage());
            }
        }

        return redirect()->to(base_url('user/riwayat'))
                         ->with('success', 'Pengaduan berhasil dikirim ✅');
    }

 public function riwayat()
    {
        $id_user = session()->get('id_user');

        $data['pengaduan'] = $this->pengaduanModel
            ->select('pengaduan.*, lokasi.nama_lokasi, items.nama_item')
            ->join('lokasi', 'lokasi.id_lokasi = pengaduan.id_lokasi', 'left')
            ->join('items', 'items.id_item = pengaduan.id_item', 'left')
            ->where('pengaduan.id_user', $id_user)
            ->orderBy('pengaduan.tgl_pengajuan', 'DESC')
            ->findAll();
        return view('user/riwayat', $data);
    }


    public function detail($id_pengaduan)
    {
        $id_user = session()->get('id_user');

        // Use getRowArray() to ensure we get ALL columns including foto_balasan
        $data['pengaduan'] = $this->pengaduanModel
            ->select('pengaduan.*, lokasi.nama_lokasi, items.nama_item')
            ->join('lokasi', 'lokasi.id_lokasi = pengaduan.id_lokasi', 'left')
            ->join('items', 'items.id_item = pengaduan.id_item', 'left')
            ->where('pengaduan.id_pengaduan', $id_pengaduan)
            ->where('pengaduan.id_user', $id_user)
            ->asArray()
            ->first();

        if (!$data['pengaduan']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pengaduan tidak ditemukan');
        }

        return view('user/detail', $data);
    }
}
