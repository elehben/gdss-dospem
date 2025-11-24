<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class preferensi extends Model
{
    protected $table = 'preferensi_wp';
    protected $primaryKey = 'id_preferensi';
    protected $fillable = [
        'id_alt',
        'id_user',
        'perkalian', // Vector S
        'skor_pref', // Vector V
        'rangking_wp',
    ];

    // --- Relasi ---
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'id_alt', 'id_alt');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
