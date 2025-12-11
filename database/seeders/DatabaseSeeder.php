<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            AlternatifSeeder::class,
            KriteriaSeeder::class,
            BobotBordaSeeder::class,
            PenilaianSeeder::class, // Menyimpan nilai awal & terbobot (Looping DM)
            PreferensiWpSeeder::class, // Menyimpan Vector S & V (Looping DM)
            HasilBordaSeeder::class, // Hasil Akhir
        ]);
    }
}
