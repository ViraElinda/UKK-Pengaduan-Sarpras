<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TemporaryItemModel;
use App\Models\ItemModel;
use App\Models\LokasiModel;
use App\Models\ListLokasiModel;

class TemporaryItemController extends BaseController
{
    protected $temporaryItemModel;
    protected $itemModel;
    protected $lokasiModel;
    protected $listLokasiModel;

    public function __construct()
    {
        $this->temporaryItemModel = new TemporaryItemModel();
        $this->itemModel = new ItemModel();
        $this->lokasiModel = new LokasiModel();
        $this->listLokasiModel = new ListLokasiModel();
    }

    public function index()
    {
        // Ambil semua temporary items yang pending (belum disetujui/ditolak)
        $data['temporaryItems'] = $this->temporaryItemModel
            ->where('status', 'pending')
            ->orderBy('id_temporary', 'DESC')
            ->findAll();

        return view('admin/temporary_items/index', $data);
    }

    public function approve($id)
    {
        $temporaryItem = $this->temporaryItemModel->find($id);

        if (!$temporaryItem) {
            return redirect()->to('admin/temporary_items')->with('error', 'Data tidak ditemukan');
        }

        // Pindahkan ke table items
        $itemData = [
            'id_temporary' => $temporaryItem['id_temporary'],
            'nama_item' => $temporaryItem['nama_barang_baru'],
            'lokasi' => $temporaryItem['lokasi_barang_baru'],
            'deskripsi' => 'Item dari temporary approval',
            'foto' => null
        ];

        $itemId = $this->itemModel->insert($itemData);
        if ($itemId) {
            // Jika user menginput nama lokasi, coba cari id_lokasi; jika tidak ada, buat baru
            $lokasiName = trim((string) ($temporaryItem['lokasi_barang_baru'] ?? ''));
            if (!empty($lokasiName)) {
                // Cari lokasi existing (case-sensitive match). If not found, create it.
                $lokasiRow = $this->lokasiModel->where('nama_lokasi', $lokasiName)->first();
                if (!$lokasiRow) {
                    $newLokId = $this->lokasiModel->insert(['nama_lokasi' => $lokasiName]);
                    $lokasiId = $newLokId ?: null;
                } else {
                    $lokasiId = $lokasiRow['id_lokasi'];
                }

                if (!empty($lokasiId)) {
                    // Insert mapping to list_lokasi
                    $this->listLokasiModel->insert([
                        'id_lokasi' => $lokasiId,
                        'id_item' => $itemId,
                    ]);
                }
            }

            // Update status temporary item menjadi approved
            $this->temporaryItemModel->update($id, ['status' => 'approved']);

            return redirect()->to('admin/temporary_items')->with('success', 'Item berhasil disetujui dan dipindahkan ke daftar items');
        } else {
            return redirect()->to('admin/temporary_items')->with('error', 'Gagal memindahkan item');
        }
    }

    public function reject($id)
    {
        $temporaryItem = $this->temporaryItemModel->find($id);

        if (!$temporaryItem) {
            return redirect()->to('admin/temporary_items')->with('error', 'Data tidak ditemukan');
        }

        // Update status menjadi rejected (tetap di temporary_item)
        if ($this->temporaryItemModel->update($id, ['status' => 'rejected'])) {
            return redirect()->to('admin/temporary_items')->with('success', 'Item telah ditolak');
        } else {
            return redirect()->to('admin/temporary_items')->with('error', 'Gagal menolak item');
        }
    }

    public function history()
    {
        // Tampilkan semua temporary items (approved dan rejected)
        $data['temporaryItems'] = $this->temporaryItemModel
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('id_temporary', 'DESC')
            ->findAll();

        return view('admin/temporary_items/history', $data);
    }
}
