<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PetugasModel;

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
        $petugasModel = new PetugasModel();

        $fotoName = null;

        if ($file = $this->request->getFile('foto')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $fotoName = $file->getRandomName();
                $file->move('uploads/user', $fotoName);
            }
        }

        $role = $this->request->getPost('role');
        $namaPengguna = $this->request->getPost('nama_pengguna');

        // Insert ke tabel user
        $userId = $userModel->insert([
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_pengguna' => $namaPengguna,
            'role'          => $role,
            'foto'          => $fotoName,
        ]);

        // Jika role petugas, insert juga ke tabel petugas
        if ($role === 'petugas' && $userId) {
            $petugasModel->insert([
                'id_user' => $userId,
                'nama'    => $namaPengguna,
            ]);
        }

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
        $petugasModel = new PetugasModel();

        $oldUser = $userModel->find($id);
        $newRole = $this->request->getPost('role');
        $namaPengguna = $this->request->getPost('nama_pengguna');

        $dataUpdate = [
            'username'      => $this->request->getPost('username'),
            'nama_pengguna' => $namaPengguna,
            'role'          => $newRole,
        ];

        if ($this->request->getPost('password')) {
            $dataUpdate['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($file = $this->request->getFile('foto')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $fotoName = $file->getRandomName();
                $file->move('uploads/user', $fotoName);
                $dataUpdate['foto'] = $fotoName;
            }
        }

        $userModel->update($id, $dataUpdate);

        // Sinkronisasi tabel petugas
        $petugas = $petugasModel->where('id_user', $id)->first();

        if ($newRole === 'petugas') {
            // Jika role sekarang petugas
            if ($petugas) {
                // Update data petugas yang sudah ada
                $petugasModel->update($petugas['id_petugas'], [
                    'nama' => $namaPengguna,
                ]);
            } else {
                // Buat data petugas baru
                $petugasModel->insert([
                    'id_user' => $id,
                    'nama'    => $namaPengguna,
                ]);
            }
        } else {
            // Jika role bukan petugas, hapus dari tabel petugas jika ada
            if ($petugas) {
                $petugasModel->delete($petugas['id_petugas']);
            }
        }

        return redirect()->to('/admin/users')->with('success', 'User berhasil diperbarui');
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $petugasModel = new PetugasModel();

        // Hapus dari tabel petugas jika ada
        $petugas = $petugasModel->where('id_user', $id)->first();
        if ($petugas) {
            $petugasModel->delete($petugas['id_petugas']);
        }

        // Hapus dari tabel user
        $userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus');
    }
}
