<?php
namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table      = 'items';
    protected $primaryKey = 'id_item';

    protected $allowedFields = [
        'id_temporary',
        'nama_item',
        'lokasi',
        'deskripsi',
        'foto'
    ];

    public function findAll(?int $limit = null, int $offset = 0)
    {
        if ($limit !== null) {
            $this->limit($limit, $offset);
        }
        return $this->orderBy('id_item', 'DESC')->find();
    }
}
