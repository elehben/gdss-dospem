<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HasilBordaSeeder extends Seeder
{
    public function run(): void
    {
        // Seed data untuk tahun 2025 dan 2026
        $this->seedForYear(2025);
        $this->seedForYear(2026);
    }

    private function seedForYear($tahun)
    {
        // Data format: [Alt => [Total Poin Borda, Nilai Borda, Ranking]]
        $results = [
            'A01' => [3.1056, 0.2168, 1],
            'A02' => [2.5698, 0.1794, 2],
            'A03' => [2.0528, 0.1433, 4],
            'A04' => [2.1324, 0.1489, 3],
            'A05' => [1.6686, 0.1165, 5],
            'A06' => [0.6780, 0.0473, 8],
            'A07' => [0.7588, 0.0529, 7],
            'A08' => [0.9221, 0.0643, 6],
            'A09' => [0.0000, 0.0000, 10], // Nilai Borda sangat kecil/0 berdasarkan poin
            'A10' => [0.4316, 0.0301, 9],
        ];

        $data = [];
        foreach ($results as $altId => $val) {
            $data[] = [
                'id_alt' => $altId,
                'total_poin' => $val[0],
                'nilai_borda' => $val[1],
                'rangking_borda' => $val[2],
                'tahun' => $tahun,
            ];
        }

        DB::table('hasil_borda')->insert($data);
    }
}
