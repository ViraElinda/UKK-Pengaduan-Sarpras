<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PetugasModel;

class LoginController extends BaseController
{
    public function index()
    {
       
        return view('auth/login');
    }

    public function login()
    {
        $session = session();

        // Ambil data input
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan password harus diisi.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Pastikan password di-hash
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah.');
        }

        // Ambil role dan bersihkan spasi
        $role = strtolower(trim($user['role']));

        // Session dasar - PERMANEN
        $sessionData = [
            'id_user'       => $user['id_user'],
            'username'      => $user['username'],
            'nama_pengguna' => $user['nama_pengguna'] ?? $user['username'],
            'role'          => $role,
            'isLoggedIn'    => true,
            'login_time'    => time(), // Timestamp login untuk tracking
        ];

        // Jika petugas, ambil data petugas berdasarkan id_user
        if ($role === 'petugas') {
            $petugasModel = new PetugasModel();
            $petugas = $petugasModel->where('id_user', $user['id_user'])->first();
            if ($petugas) {
                $sessionData['id_petugas'] = $petugas['id_petugas'];
                $sessionData['nama_petugas'] = $petugas['nama'];
            }
        }

        // Set session dengan regenerasi ID untuk keamanan
        $session->set($sessionData);
        $session->regenerate(); // Regenerate session ID untuk prevent session fixation

        // Redirect dengan headers anti-cache untuk prevent back button
        $response = redirect()->to($this->getDashboardUrl($role));
        $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                 ->setHeader('Pragma', 'no-cache')
                 ->setHeader('Expires', '0');
        
        return $response;
    }

    private function getDashboardUrl($role)
    {
        switch ($role) {
            case 'admin': return '/admin/dashboard';
            case 'petugas': return '/petugas/dashboard';
            case 'user': return '/user/dashboard';
            default: return '/auth/login';
        }
    }

   public function logout()
{
    $session = session();

    // Hapus semua data session
    $session->destroy();

    // Hapus cookie PHPSESSID agar tidak auto-login
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }

    // Tambah header untuk mencegah caching
    $response = service('response');
    $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
             ->setHeader('Pragma', 'no-cache')
             ->setHeader('Expires', '0');

    // Redirect ke halaman utama (landing page)
    return redirect()->to('/')->withCookies();
}

    public function unauthorized()
{
    return redirect()->to(base_url('/'));
}


}
