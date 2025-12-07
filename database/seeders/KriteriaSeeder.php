<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriteria = [
            ['id_kriteria' => 'C1', 'nama_kriteria' => 'Tingkat Pendidikan', 'jenis' => 'Benefit', 'bobot' => 5, 'bobot_normalisasi' => 0.25],
            ['id_kriteria' => 'C2', 'nama_kriteria' => 'Jabatan Akademik', 'jenis' => 'Benefit', 'bobot' => 4, 'bobot_normalisasi' => 0.20],
            ['id_kriteria' => 'C3', 'nama_kriteria' => 'Jabatan Kelompok', 'jenis' => 'Benefit', 'bobot' => 3, 'bobot_normalisasi' => 0.15],
            ['id_kriteria' => 'C4', 'nama_kriteria' => 'Sertifikasi Dosen', 'jenis' => 'Benefit', 'bobot' => 3, 'bobot_normalisasi' => 0.15],
            ['id_kriteria' => 'C5', 'nama_kriteria' => 'Pencapaian 3 Pilar Pendidikan Tinggi', 'jenis' => 'Benefit', 'bobot' => 5, 'bobot_normalisasi' => 0.25],
        ];
        DB::table('kriteria')->insert($kriteria);
    }
}
