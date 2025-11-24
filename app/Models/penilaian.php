<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penilaian extends Model
{
    protected $table = 'penilaian';
    protected $primaryKey = 'id_penilaian';
    protected $fillable = [
        'id_user',
        'id_alt',
        'id_kriteria',
        'nilai_awal',
        'nilai_terbobot',
    ];

    // --- Relasi ---
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function alternatif()
    {
        return $this->belongsTo(alternatif::class, 'id_alt', 'id_alt');
    }

    public function kriteria()
    {
        return $this->belongsTo(kriteria::class, 'id_kriteria', 'id_kriteria');
    }
}
