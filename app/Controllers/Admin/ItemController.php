<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ItemModel;

class ItemController extends BaseController
{
    protected $itemModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $data['items'] = $this->itemModel->findAll();
        return view('admin/items/index', $data);
    }

    public function create()
    {
        return view('admin/items/create');
    }

    public function store()
    {
        $fotoFile = $this->request->getFile('foto');
        $fotoName = null;

        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $fotoName = 'foto_' . time() . '.' . $fotoFile->getExtension();
            $fotoFile->move(FCPATH . 'uploads/foto_items/', $fotoName);
        }

        $this->itemModel->insert([
            'nama_item' => $this->request->getPost('nama_item'),
            'lokasi'    => $this->request->getPost('lokasi'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'foto'     => $fotoName,
        ]);

        return redirect()->to('/admin/items')->with('success', 'Item berhasil ditambahkan.');
    }

    public function edit($id_item)
    {
        $item = $this->itemModel->find($id_item);
        if (!$item) {
            return redirect()->to('/admin/items')->with('error', 'Item tidak ditemukan.');
        }

        return view('admin/items/edit', ['item' => $item]);
    }

    public function update($id_item)
    {
        $dataUpdate = [
            'nama_item' => $this->request->getPost('nama_item'),
            'lokasi'    => $this->request->getPost('lokasi'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $fotoName = 'foto_' . time() . '.' . $fotoFile->getExtension();
            $fotoFile->move(FCPATH . 'uploads/foto_items/', $fotoName);
            $dataUpdate['foto'] = $fotoName;
        }

        $this->itemModel->update($id_item, $dataUpdate);

        return redirect()->to('/admin/items')->with('success', 'Item berhasil diperbarui.');
    }

    public function delete($id_item)
    {
        $this->itemModel->delete($id_item);
        return redirect()->to('/admin/items')->with('success', 'Item berhasil dihapus.');
    }
}
