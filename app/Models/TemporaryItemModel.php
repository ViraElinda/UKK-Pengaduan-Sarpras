<?php
namespace App\Models;

use CodeIgniter\Model;

class TemporaryItemModel extends Model
{
    protected $table      = 'temporary_item';
    protected $primaryKey = 'id_temporary';

    protected $allowedFields = [
        'id_item',
        'nama_barang_baru',
        'lokasi_barang_baru',
        'status'
    ];
}
