<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class alternatif extends Model
{
    protected $table = 'alternatif';
    protected $primaryKey = 'id_alt';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_alt',
        'nama_alt',
    ];
    // --- Relasi ---
    public function penilaians()
    {
        return $this->hasMany(penilaian::class, 'id_alt', 'id_alt');
    }

    public function hasilBorda()
    {
        return $this->hasOne(hasil::class, 'id_alt', 'id_alt');
    }

}
