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
    
    // Explicitly disable soft deletes behavior
    protected $deletedField = false;
    
    // Override to ensure no soft delete queries
    protected function doFind(bool $singleton, $id = null)
    {
        $this->tempUseSoftDeletes = false;
        return parent::doFind($singleton, $id);
    }
}
