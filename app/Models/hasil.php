<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hasil extends Model
{
    protected $table = 'hasil_borda';
    protected $primaryKey = 'id_hasil';
    protected $fillable = [
        'id_alt',
        'total_poin',
        'nilai_borda',
        'rangking_borda',
        'tahun',
    ];

    // --- Relasi ---
    public function alternatif()
    {
        return $this->belongsTo(alternatif::class, 'id_alt', 'id_alt');
    }
}
