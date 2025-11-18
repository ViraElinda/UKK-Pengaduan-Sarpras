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

        $userId = session()->get('id_user');
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

        $userId = session()->get('id_user');
        $user   = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Validasi input
        $rules = [
            'nama_pengguna' => 'required|min_length[3]',
            'username' => 'required|min_length[3]',
        ];

        // Jika user mengisi password, wajib minimal 6 karakter
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            // Periksa apakah error karena password
            $errors = service('validation')->getErrors();
            if (isset($errors['password'])) {
                return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter jika ingin mengganti.');
            }

            return redirect()->back()->withInput()->with('error', 'Nama pengguna dan username minimal 3 karakter');
        }

        $data = [
            'nama_pengguna' => $this->request->getPost('nama_pengguna'),
            'username'      => $this->request->getPost('username'),
        ];

        // ✅ Update password jika diisi
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // ✅ Upload foto
        $file = $this->request->getFile('profile_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validasi tipe file
            $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return redirect()->back()->with('error', 'Format file harus JPG, PNG, atau GIF');
            }

            // Validasi ukuran (max 2MB)
            if ($file->getSize() > 2048000) {
                return redirect()->back()->with('error', 'Ukuran file maksimal 2MB');
            }

            $newName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/foto_user';

            // Buat folder jika belum ada
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Pastikan folder bisa ditulis oleh proses PHP
            if (!is_writable($uploadPath)) {
                // Coba set permission yang lebih permisif; ini bisa gagal on some hosts
                @chmod($uploadPath, 0775);

                if (!is_writable($uploadPath)) {
                    // Log detail supaya bisa dianalisa di server
                    log_message('error', "Upload gagal: folder tidak writable: {$uploadPath}");
                    return redirect()->back()->with('error', 'Direktori upload tidak dapat ditulis. Periksa permission folder uploads/foto_user pada server.');
                }
            }

            // ✅ Hapus file lama
            if (!empty($user['foto']) && $user['foto'] !== 'default.png') {
                $oldPath = $uploadPath . '/' . $user['foto'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Move file
            if ($file->move($uploadPath, $newName)) {
                $data['foto'] = $newName;
            } else {
                return redirect()->back()->with('error', 'Gagal mengupload foto');
            }
        }

        // Update database
        if ($this->userModel->update($userId, $data)) {
            // Update session dengan data terbaru
            $updatedUser = $this->userModel->find($userId);
            session()->set('user', $updatedUser);

            return redirect()->to('user/profile')->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui profil');
        }
    }
}
