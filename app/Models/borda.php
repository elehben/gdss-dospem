<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class borda extends Model
{
    protected $table = 'bobot_borda';
    protected  $primaryKey = 'ranking';
    protected $fillable = [
        'ranking',
        'bobot_borda',
    ];
}
