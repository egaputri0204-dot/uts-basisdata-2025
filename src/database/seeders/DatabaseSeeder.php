<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RumahSakitSeeder::class,
            PasienSeeder::class,
            PoliklinikSeeder::class,
            DokterSeeder::class,
            KunjunganSeeder::class,
            ObatSeeder::class,
            ResepSeeder::class,
            JadwalPraktekSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
