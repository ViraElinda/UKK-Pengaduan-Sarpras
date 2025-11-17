<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class PetugasController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // join with user to display username when available
        $builder = $db->table('petugas p')
            ->select('p.*, u.username')
            ->join('user u', 'p.id_user = u.id_user', 'left')
            ->orderBy('p.id_petugas', 'DESC');

        $data['petugas'] = $builder->get()->getResultArray();

        return view('admin/petugas/index', $data);
    }

    public function create()
    {
        // fetch users with role 'petugas' (or users without petugas yet)
        $userModel = new UserModel();
        $data['users'] = $userModel->where('role', 'petugas')->findAll();

        return view('admin/petugas/create', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();

        $data = [
            'id_user'    => $this->request->getPost('id_user') ?: null,
            'nama'       => $this->request->getPost('nama'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $db->table('petugas')->insert($data);

        return redirect()->to('/admin/petugas')->with('success', 'Petugas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $db = \Config\Database::connect();
        $petugas = $db->table('petugas')->where('id_petugas', $id)->get()->getRowArray();

        if (!$petugas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Petugas tidak ditemukan');
        }

        $userModel = new UserModel();
        $data['users'] = $userModel->where('role', 'petugas')->findAll();
        $data['petugas'] = $petugas;

        return view('admin/petugas/edit', $data);
    }

    public function update($id)
    {
        $db = \Config\Database::connect();

        $data = [
            'id_user' => $this->request->getPost('id_user') ?: null,
            'nama'    => $this->request->getPost('nama'),
        ];

        $db->table('petugas')->where('id_petugas', $id)->update($data);

        return redirect()->to('/admin/petugas')->with('success', 'Petugas berhasil diperbarui');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('petugas')->where('id_petugas', $id)->delete();

        return redirect()->to('/admin/petugas')->with('success', 'Petugas berhasil dihapus');
    }
}
