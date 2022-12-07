<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelmakanan extends Model
{
    protected $table         = 'makanan';
    protected $primaryKey    = 'id';
    protected $useAutoIncrement = 'true';
    protected $allowedFields =[
         'nama_makanan','harga'
    ];
}
