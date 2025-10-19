<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('admin/users/index', $data);
    }

    public function create()
    {
        return view('admin/users/create');
    }

    public function store()
    {
        $userModel = new UserModel();

        $userModel->insert([
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_pengguna' => $this->request->getPost('nama_pengguna'),
            'role'          => $this->request->getPost('role'),
        ]);

        return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);

        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User tidak ditemukan");
        }

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();

        $dataUpdate = [
            'username'      => $this->request->getPost('username'),
            'nama_pengguna' => $this->request->getPost('nama_pengguna'),
            'role'          => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password')) {
            $dataUpdate['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($id, $dataUpdate);

        return redirect()->to('/admin/users')->with('success', 'User berhasil diperbarui');
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus');
    }
}
