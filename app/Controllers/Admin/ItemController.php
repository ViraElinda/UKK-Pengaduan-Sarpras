<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ItemModel;
use App\Models\LokasiModel;
use App\Models\ListLokasiModel;

class ItemController extends BaseController
{
    protected $itemModel;
    protected $lokasiModel;
    protected $listLokasiModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
        $this->lokasiModel = new LokasiModel();
        $this->listLokasiModel = new ListLokasiModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        // Get all items with their locations
        $db = \Config\Database::connect();
        $builder = $db->table('items i');
        $builder->select('i.*, GROUP_CONCAT(DISTINCT l.nama_lokasi SEPARATOR ", ") as lokasi_list');
        $builder->join('list_lokasi ll', 'll.id_item = i.id_item', 'left');
        $builder->join('lokasi l', 'l.id_lokasi = ll.id_lokasi', 'left');
        $builder->groupBy('i.id_item');
        $builder->orderBy('i.id_item', 'DESC');
        
        $data['items'] = $builder->get()->getResultArray();
        return view('admin/items/index', $data);
    }

    public function create()
    {
        $data['lokasi'] = $this->lokasiModel->findAll();
        return view('admin/items/create', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_item' => 'required',
            'deskripsi' => 'required',
            'lokasi_ids' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', 'Semua field harus diisi!');
        }

        $fotoFile = $this->request->getFile('foto');
        $fotoName = null;

        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $fotoName = 'foto_' . time() . '.' . $fotoFile->getExtension();
            $fotoFile->move(FCPATH . 'uploads/foto_items/', $fotoName);
        }

        // Insert item
        $itemId = $this->itemModel->insert([
            'nama_item' => $this->request->getPost('nama_item'),
            'lokasi'    => '',
            'deskripsi' => $this->request->getPost('deskripsi'),
            'foto'     => $fotoName,
        ]);

        // Insert to list_lokasi
        $lokasiIds = $this->request->getPost('lokasi_ids');
        if ($lokasiIds) {
            foreach ($lokasiIds as $lokasiId) {
                $this->listLokasiModel->insert([
                    'id_lokasi' => $lokasiId,
                    'id_item' => $itemId,
                ]);
            }
        }

        return redirect()->to('/admin/items')->with('success', 'Item berhasil ditambahkan.');
    }

    public function edit($id_item)
    {
        $item = $this->itemModel->find($id_item);
        if (!$item) {
            return redirect()->to('/admin/items')->with('error', 'Item tidak ditemukan.');
        }

        $data['item'] = $item;
        $data['lokasi'] = $this->lokasiModel->findAll();
        
        // Get selected locations for this item
        $data['selected_lokasi'] = $this->listLokasiModel->where('id_item', $id_item)->findColumn('id_lokasi');

        return view('admin/items/edit', $data);
    }

    public function update($id_item)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_item' => 'required',
            'deskripsi' => 'required',
            'lokasi_ids' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', 'Semua field harus diisi!');
        }

        $dataUpdate = [
            'nama_item' => $this->request->getPost('nama_item'),
            'lokasi'    => '',
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $fotoName = 'foto_' . time() . '.' . $fotoFile->getExtension();
            $fotoFile->move(FCPATH . 'uploads/foto_items/', $fotoName);
            $dataUpdate['foto'] = $fotoName;
        }

        $this->itemModel->update($id_item, $dataUpdate);

        // Update list_lokasi - delete old and insert new
        $this->listLokasiModel->where('id_item', $id_item)->delete();
        
        $lokasiIds = $this->request->getPost('lokasi_ids');
        if ($lokasiIds) {
            foreach ($lokasiIds as $lokasiId) {
                $this->listLokasiModel->insert([
                    'id_lokasi' => $lokasiId,
                    'id_item' => $id_item,
                ]);
            }
        }

        return redirect()->to('/admin/items')->with('success', 'Item berhasil diperbarui.');
    }

    public function delete($id_item)
    {
        // Delete from list_lokasi first
        $this->listLokasiModel->where('id_item', $id_item)->delete();
        
        // Delete item
        $this->itemModel->delete($id_item);
        
        return redirect()->to('/admin/items')->with('success', 'Item berhasil dihapus.');
    }
}
