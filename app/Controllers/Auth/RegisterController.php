<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class RegisterController extends BaseController
{
    public function index()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (session()->get('isLoggedIn')) {
            $role = strtolower(trim(session()->get('role')));
            
            switch ($role) {    
                case 'admin':
                    return redirect()->to('/admin/dashboard');
                case 'petugas':
                    return redirect()->to('/petugas/dashboard');
                case 'user':
                    return redirect()->to('/user/dashboard');
                default:
                    session()->destroy();
                    return redirect()->to('/auth/login');
            }
        }
        
        return view('auth/register');
    }

    public function register()
    {
        $userModel = new UserModel();

        $nama_pengguna = $this->request->getPost('nama_pengguna');
        $username      = $this->request->getPost('username');
        $password      = $this->request->getPost('password');
        
        // Auto set role sebagai 'user' untuk registrasi public
        $role = 'user';

        // Validasi field
        if (!$nama_pengguna || !$username || !$password) {
            return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter.');
        }

        // Cek username sudah digunakan
        if ($userModel->where('username', $username)->first()) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan.');
        }

        // Insert ke tabel user dengan role 'user'
        $data = [
            'nama_pengguna' => $nama_pengguna,
            'username'      => $username,
            'password'      => password_hash($password, PASSWORD_DEFAULT),
            'role'          => $role,
        ];
        
        $userModel->insert($data);

        return redirect()->to('/auth/login')
                         ->with('success', 'Berhasil daftar! Silakan login sebagai User.');
    }
}
    