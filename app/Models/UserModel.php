<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id_user';

    protected $allowedFields = [
        'username',
        'password',
        'nama_pengguna',
        'role',
        'foto',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $returnType    = 'array';

    public function findAll(?int $limit = null, int $offset = 0)
    {
        if ($limit !== null) {
            $this->limit($limit, $offset);
        }
        return $this->orderBy('id_user', 'DESC')->find();
    }
}
