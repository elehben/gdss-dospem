<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class alternatif extends Model
{
    protected $table = 'alternatif';
    protected $primaryKey = 'id_alt';
    protected $guarded = ['id_alt'];
}
