<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiModel extends Model
{
    protected $table = 'lokasi';
    protected $primaryKey = 'id_lokasi';
    protected $allowedFields = ['nama_lokasi'];
    protected $returnType = 'array';

    public function findAll(?int $limit = null, int $offset = 0)
    {
        if ($limit !== null) {
            $this->limit($limit, $offset);
        }
        return $this->orderBy('id_lokasi', 'DESC')->find();
    }
}
