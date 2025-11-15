<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PetugasModel;
use App\Models\UserModel;

class PetugasController extends BaseController
{
    public function index()
    {
        $petugasModel = new PetugasModel();
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
        $petugasModel = new PetugasModel();

        $data = [
            'id_user' => $this->request->getPost('id_user') ?: null,
            'nama'    => $this->request->getPost('nama'),
        ];

        $petugasModel->insert($data);

        return redirect()->to('/admin/petugas')->with('success', 'Petugas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $petugasModel = new PetugasModel();
        $petugas = $petugasModel->find($id);

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
        $petugasModel = new PetugasModel();

        $data = [
            'id_user' => $this->request->getPost('id_user') ?: null,
            'nama'    => $this->request->getPost('nama'),
        ];

        $petugasModel->update($id, $data);

        return redirect()->to('/admin/petugas')->with('success', 'Petugas berhasil diperbarui');
    }

    public function delete($id)
    {
        $petugasModel = new PetugasModel();
        $petugasModel->delete($id);

        return redirect()->to('/admin/petugas')->with('success', 'Petugas berhasil dihapus');
    }
}
