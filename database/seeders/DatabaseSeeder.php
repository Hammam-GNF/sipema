<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PetugasSeeder::class,
            PengaduanSeeder::class,
            TindakLanjutSeeder::class,
            NotifikasiSeeder::class,
            LaporanSeeder::class
        ]);
    }
}
