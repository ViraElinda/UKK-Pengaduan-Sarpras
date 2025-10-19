<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table      = 'items';
    protected $primaryKey = 'id_item';

    protected $allowedFields = ['nama_item', 'lokasi', 'deskripsi', 'foto'];

    // Kalau mau tambah fungsi custom, bisa di sini
}
