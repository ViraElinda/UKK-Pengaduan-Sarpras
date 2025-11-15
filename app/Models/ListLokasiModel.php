<?php

namespace App\Models;

use CodeIgniter\Model;

class ListLokasiModel extends Model
{
    protected $table = 'list_lokasi';
    protected $primaryKey = 'id_list';
    protected $allowedFields = ['id_list', 'id_lokasi', 'id_item'];
}
