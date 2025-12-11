<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreferensiWPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data untuk tahun 2025 dan 2026
        $this->seedForYear(2025);
        $this->seedForYear(2026);
    }

    private function seedForYear($tahun)
    {
        // Data format: [Alt => [Perkalian, Skor Pref, Ranking]]
        
        // DM 1 [cite: 3]
        $dm1 = [
            'A01' => [2.5491, 0.1119, 1], 'A02' => [2.4414, 0.1072, 3], 'A03' => [2.5491, 0.1119, 2],
            'A04' => [2.4414, 0.1072, 4], 'A05' => [2.4371, 0.1070, 5], 'A06' => [2.1254, 0.0933, 8],
            'A07' => [2.1449, 0.0941, 7], 'A08' => [2.2779, 0.1000, 6], 'A09' => [1.7872, 0.0784, 10],
            'A10' => [2.0184, 0.0886, 9]
        ];

        // DM 2 [cite: 6]
        $dm2 = [
            'A01' => [2.6953, 0.1179, 1], 'A02' => [2.5815, 0.1129, 2], 'A03' => [2.3722, 0.1038, 5],
            'A04' => [2.4414, 0.1068, 3], 'A05' => [2.4371, 0.1066, 4], 'A06' => [2.2473, 0.0983, 6],
            'A07' => [2.1449, 0.0938, 7], 'A08' => [2.1198, 0.0927, 8], 'A09' => [1.7872, 0.0782, 10],
            'A10' => [2.0184, 0.0883, 9]
        ];

        // DM 3 [cite: 9]
        $dm3 = [
            'A01' => [2.6953, 0.1151, 1], 'A02' => [2.5815, 0.1102, 2], 'A03' => [2.5491, 0.1089, 4],
            'A04' => [2.5815, 0.1102, 3], 'A05' => [2.3049, 0.0984, 5], 'A06' => [2.1254, 0.0907, 9],
            'A07' => [2.1449, 0.0916, 8], 'A08' => [2.2779, 0.0973, 6], 'A09' => [1.9779, 0.0844, 10],
            'A10' => [2.1689, 0.0926, 7]
        ];

        $this->insertPreferensi('U0002', $dm1, $tahun);
        $this->insertPreferensi('U0003', $dm2, $tahun);
        $this->insertPreferensi('U0004', $dm3, $tahun);
    }

    private function insertPreferensi($userId, $data, $tahun)
    {
        $insert = [];
        foreach ($data as $altId => $values) {
            $insert[] = [
                'id_user' => $userId,
                'id_alt' => $altId,
                'perkalian' => $values[0],
                'skor_pref' => $values[1],
                'rangking_wp' => $values[2],
                'tahun' => $tahun,
            ];
        }
        DB::table('preferensi_wp')->insert($insert);
    }
}
