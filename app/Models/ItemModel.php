<?php

namespace App\Models;
use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'id_item';
    protected $allowedFields = ['nama_item', 'deskripsi', 'foto'];
    protected $returnType = 'array';
}
