<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelmakanan extends Model
{
    protected $table         = 'makanan';
    protected $primaryKey    = 'id';
    protected $allowedFields =[
         'id','nama_makanan','harga'
    ];
}
