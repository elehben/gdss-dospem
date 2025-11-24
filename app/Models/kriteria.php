<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kriteria extends Model
{
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_kriteria',
        'nama_kriteria',
        'jenis', // Benefit atau Cost
        'bobot',
        'bobot_normalisasi',
    ];

    // --- Relasi ---
    public function penilaians()
    {
        return $this->hasMany(penilaian::class, 'id_kriteria', 'id_kriteria');
    }
}
