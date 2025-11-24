<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hasil extends Model
{
    protected $table = 'hasil_borda';
    protected $primaryKey = 'id_hasil';
    protected $guarded = ['id_hasil'];
}
