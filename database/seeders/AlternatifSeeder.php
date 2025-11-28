<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlternatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alternatifs = [
            ['id_alt' => 'A01',  'nama_alt' => 'Dr. Budi Santoso, M.Kom.'],
            ['id_alt' => 'A02',  'nama_alt' => 'Prof. Dr. Siti Aminah, S.Si., M.T.'],
            ['id_alt' => 'A03',  'nama_alt' => 'Rahmat Hidayat, S.T., M.Cs.'],
            ['id_alt' => 'A04',  'nama_alt' => 'Dr. Eko Prasetyo, S.Kom., M.Kom.'],
            ['id_alt' => 'A05',  'nama_alt' => 'Dewi Sartika, S.T., M.T.'],
            ['id_alt' => 'A06',  'nama_alt' => 'Dr. Ir. Andi Wijaya, M.Eng.'],
            ['id_alt' => 'A07',  'nama_alt' => 'Ratna Sari, S.Kom., M.MSI.'],
            ['id_alt' => 'A08',  'nama_alt' => 'Bambang Suryadi, Ph.D.'],
            ['id_alt' => 'A09',  'nama_alt' => 'Lina Marlina, S.Si., M.Kom.'],
            ['id_alt' => 'A10', 'nama_alt' => 'Dr. Hendra Gunawan, S.T., M.T.'],
        ];

        DB::table('alternatif')->insert($alternatifs);
    }
}
