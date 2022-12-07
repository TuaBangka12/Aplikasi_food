<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeluser extends Model
{
   protected $table         = 'user';
   protected $primaryKey    = 'id';
   protected $allowedFields =[
        'id','user','password','email','tanggal_lahir','nomorHP'
   ];
}
