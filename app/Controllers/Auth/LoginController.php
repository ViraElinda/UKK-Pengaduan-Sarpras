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
    $model = new UserModel();

    // Ambil input dari form
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    // Cari user berdasarkan username
    $user = $model->where('username', $username)->first();

    // Validasi: user tidak ditemukan
    if (!$user) {
        return redirect()->back()->withInput()->with('error', 'User tidak ditemukan.');
    }

    // Validasi: password salah
    if (!password_verify($password, $user['password'])) {
        return redirect()->back()->withInput()->with('error', 'Password salah.');
    }

    // Validasi: kolom role harus ada
    if (!isset($user['role'])) {
        return redirect()->back()->withInput()->with('error', 'Role tidak ditemukan.');
    }

    // Set session
    $session->set([
        'user_id'    => $user['id_user'],
        'username'   => $user['username'],
        'role'       => strtolower($user['role']), // lowercase untuk konsistensi
        'isLoggedIn' => true,
    ]);

    // Redirect berdasarkan role
    switch (strtolower($user['role'])) {
        case 'admin':
            return redirect()->to('/admin/dashboard');
        case 'petugas':
            return redirect()->to('/petugas/dashboard');
        case 'guru':
            return redirect()->to('/guru/dashboard');
        case 'siswa':
            return redirect()->to('/siswa/dashboard');
        case 'user':
            return redirect()->to('/user/dashboard');
        default:
            // Jika role tidak dikenali, logout dan beri pesan error
            $session->destroy();
            return redirect()->to('/auth/login')->with('error', 'Akses tidak diizinkan.');
    }

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
