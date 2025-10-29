<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model   = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cek username
        $user = $model->where('username', $username)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Cek password
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }

        if (!isset($user['role'])) {
            return redirect()->back()->with('error', 'Role tidak ditemukan.');
        }

        // Simpan session lengkap
        $session->set([
            'user_id'       => $user['id_user'],
            'username'      => $user['username'],
            'nama_pengguna' => $user['nama_pengguna'] ?? $user['username'],
            'foto'          => $user['foto'] ?? null,
            'role'          => strtolower($user['role']),
            'isLoggedIn'    => true,
        ]);

        // Redirect berdasar role
        $role = strtolower($user['role']);

        return match ($role) {
            'admin'   => redirect()->to('/admin/dashboard'),
            'petugas' => redirect()->to('/petugas/dashboard'),
            'guru'    => redirect()->to('/guru/dashboard'),
            'siswa'   => redirect()->to('/siswa/dashboard'),
            'user'    => redirect()->to('/user/dashboard'),
            default   => redirect()->to('/auth/login')->with('error', 'Akses tidak diizinkan.')
        };
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }

    public function unauthorized()
    {
        return view('errors/unauthorized');
    }
}
