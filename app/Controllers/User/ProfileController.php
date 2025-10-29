<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');
        $user   = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Data user tidak ditemukan');
        }

        $user['foto'] = $user['foto'] ?? 'default.png';

        return view('user/profile', compact('user'));
    }

    public function update()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');
        $user   = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        $data = [
            'nama_pengguna' => $this->request->getPost('nama_pengguna'),
            'username'      => $this->request->getPost('username'),
        ];

        // ✅ Update password jika diisi
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // ✅ Upload foto
        $file = $this->request->getFile('profile_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {

            $newName = $file->getRandomName();
            $uploadPath = WRITEPATH . 'uploads/profile';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // ✅ Hapus file lama
            if (!empty($user['foto']) && $user['foto'] !== 'default.png') {
                $oldPath = $uploadPath . '/' . $user['foto'];
                if (file_exists($oldPath)) unlink($oldPath);
            }

            $file->move($uploadPath, $newName);
            $data['foto'] = $newName;

            session()->set('foto', $newName);
        }

        $this->userModel->update($userId, $data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
}
