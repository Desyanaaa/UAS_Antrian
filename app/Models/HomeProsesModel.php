<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeProsesModel extends Model{
    protected $DBGroup          = 'default';
    protected $table            = 'antrian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['tanggal', 'no_antrian', 'status', 'waktu_panggil', 'waktu_selesai', 'pelayanan_id', 'loket_id'];
}
