<?php

namespace App\Models;

use CodeIgniter\Model;

class PelayananProsesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pelayanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'keterangan', 'kode'];
}
