<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{public function profile()
{
    $session = session();
    $user = $session->get('user') ?? [];

    // Pastikan semua key ada
    $user['nama_pengguna'] = $user['nama_pengguna'] ?? '';
    $user['username']     = $user['username'] ?? '';
    $user['foto']         = $user['foto'] ?? '';

    return view('user/profile', ['user' => $user]);
}

}
