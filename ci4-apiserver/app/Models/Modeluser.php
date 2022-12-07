<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeluser extends Model
{
   protected $table         = 'user';
   protected $primaryKey    = 'id';
   protected $useAutoIncrement = true;
   protected $allowedFields =[
        'user','password','email','tanggal_lahir','nomorHP'
   ];
}
