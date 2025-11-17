<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
    protected $table      = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $allowedFields = [
        'id_user',
        'nama',
        'created_at'
    ];

    protected $useSoftDeletes = false;
    protected $useTimestamps  = false;
}
