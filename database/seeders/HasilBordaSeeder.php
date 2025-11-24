<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HasilBordaSeeder extends Seeder
{
    public function run(): void
    {
        // Data format: [Alt => [Total Poin Borda, Nilai Borda, Ranking]]
        $results = [
            'A1' => [3.1056, 0.2168, 1],
            'A2' => [2.5698, 0.1794, 2],
            'A3' => [2.0528, 0.1433, 4],
            'A4' => [2.1324, 0.1489, 3],
            'A5' => [1.6686, 0.1165, 5],
            'A6' => [0.6780, 0.0473, 8],
            'A7' => [0.7588, 0.0529, 7],
            'A8' => [0.9221, 0.0643, 6],
            'A9' => [0.0000, 0.0000, 10], // Nilai Borda sangat kecil/0 berdasarkan poin
            'A10' => [0.4316, 0.0301, 9],
        ];

        $data = [];
        foreach ($results as $altId => $val) {
            $data[] = [
                'id_alt' => $altId,
                'total_poin' => $val[0],
                'nilai_borda' => $val[1],
                'rangking_borda' => $val[2],
            ];
        }

        DB::table('hasil_borda')->insert($data);
    }
}
