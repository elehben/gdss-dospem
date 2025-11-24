<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class preferensi extends Model
{
    protected $table = 'preferensi_wp';
    protected $primaryKey = 'id_preferensi';
    protected $guarded = ['id_preferensi'];
}
