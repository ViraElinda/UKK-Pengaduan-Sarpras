<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id_user';

    protected $allowedFields = ['username', 'password', 'nama_pengguna', 'role', 'created_at'];
    protected $useTimestamps = false;
    protected $returnType = 'array'; // ⬅️ WAJIB! Agar bisa pakai $user['id']

}
