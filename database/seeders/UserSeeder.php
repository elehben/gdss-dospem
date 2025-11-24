<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id_user' => 'U0001',
                'name' => 'Administrator',
                'email' => 'admin@gdss.com',
                'password' => Hash::make('1234'),
                'created_at' => now(),
            ],
            [
                'id_user' => 'U0002', // DM 1 (Kepala Departemen)
                'name' => 'Kepala Departemen',
                'email' => 'kadep@gdss.com',
                'password' => Hash::make('222'),
                'created_at' => now(),
            ],
            [
                'id_user' => 'U0003', // DM 2 (Sekretaris Departemen)
                'name' => 'Sekretaris Departemen',
                'email' => 'sekdep@gdss.com',
                'password' => Hash::make('333'),
                'created_at' => now(),
            ],
            [
                'id_user' => 'U0004', // DM 3 (Kepala Program Studi)
                'name' => 'Kepala Program Studi',
                'email' => 'kaprodi@gdss.com',
                'password' => Hash::make('444'),
                'created_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
