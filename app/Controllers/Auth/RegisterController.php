<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class RegisterController extends BaseController
{
    public function index()
    {
        return view('auth/register');
    }

   public function register()
{
    $userModel = new UserModel();

    $nama_pengguna = $this->request->getPost('nama_pengguna');
    $username      = $this->request->getPost('username');
    $password      = $this->request->getPost('password');
    $role          = $this->request->getPost('role');

    // Validasi form
    if (empty($nama_pengguna) || empty($username) || empty($password) || empty($role)) {
        return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi.');
    }

    if (strlen($password) < 6) {
        return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter.');
    }

    // Validasi role
    $allowedRoles = ['admin', 'guru', 'siswa', 'petugas', 'user'];
    if (!in_array(strtolower($role), $allowedRoles)) {
        return redirect()->back()->withInput()->with('error', 'Role tidak valid.');
    }

    // Cek apakah username sudah digunakan
    if ($userModel->where('username', $username)->first()) {
        return redirect()->back()->withInput()->with('error', 'Username sudah digunakan.');
    }

    // Simpan user baru
    $userModel->save([
        'nama_pengguna' => $nama_pengguna,
        'username'      => $username,
        'password'      => password_hash($password, PASSWORD_DEFAULT),
        'role'          => strtolower($role), // simpan role lowercase
        'created_at'    => date('Y-m-d H:i:s')
    ]);

    return redirect()->to('/auth/login')->with('success', 'Berhasil daftar! Silakan login.');
}

}