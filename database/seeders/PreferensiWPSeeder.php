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
        // Data format: [Alt => [Perkalian, Skor Pref, Ranking]]
        
        // DM 1 [cite: 3]
        $dm1 = [
            'A1' => [2.5491, 0.1119, 1], 'A2' => [2.4414, 0.1072, 3], 'A3' => [2.5491, 0.1119, 2],
            'A4' => [2.4414, 0.1072, 4], 'A5' => [2.4371, 0.1070, 5], 'A6' => [2.1254, 0.0933, 8],
            'A7' => [2.1449, 0.0941, 7], 'A8' => [2.2779, 0.1000, 6], 'A9' => [1.7872, 0.0784, 10],
            'A10' => [2.0184, 0.0886, 9]
        ];

        // DM 2 [cite: 6]
        $dm2 = [
            'A1' => [2.6953, 0.1179, 1], 'A2' => [2.5815, 0.1129, 2], 'A3' => [2.3722, 0.1038, 5],
            'A4' => [2.4414, 0.1068, 3], 'A5' => [2.4371, 0.1066, 4], 'A6' => [2.2473, 0.0983, 6],
            'A7' => [2.1449, 0.0938, 7], 'A8' => [2.1198, 0.0927, 8], 'A9' => [1.7872, 0.0782, 10],
            'A10' => [2.0184, 0.0883, 9]
        ];

        // DM 3 [cite: 9]
        $dm3 = [
            'A1' => [2.6953, 0.1151, 1], 'A2' => [2.5815, 0.1102, 2], 'A3' => [2.5491, 0.1089, 4],
            'A4' => [2.5815, 0.1102, 3], 'A5' => [2.3049, 0.0984, 5], 'A6' => [2.1254, 0.0907, 9],
            'A7' => [2.1449, 0.0916, 8], 'A8' => [2.2779, 0.0973, 6], 'A9' => [1.9779, 0.0844, 10],
            'A10' => [2.1689, 0.0926, 7]
        ];

        $this->insertPreferensi('U0002', $dm1);
        $this->insertPreferensi('U0003', $dm2);
        $this->insertPreferensi('U0004', $dm3);
    }

    private function insertPreferensi($userId, $data)
    {
        $insert = [];
        foreach ($data as $altId => $values) {
            $insert[] = [
                'id_user' => $userId,
                'id_alt' => $altId,
                'perkalian' => $values[0],
                'skor_pref' => $values[1],
                'rangking_wp' => $values[2],
            ];
        }
        DB::table('preferensi_wp')->insert($insert);
    }
}
