<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BobotBordaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        // Ranking 1 bobot 9, Ranking 2 bobot 8, dst hingga Ranking 10 bobot 0
        $bobot = 9;
        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'ranking' => $i,
                'bobot_borda' => $bobot--,
            ];
        }
        DB::table('bobot_borda')->insert($data);
    }
}
