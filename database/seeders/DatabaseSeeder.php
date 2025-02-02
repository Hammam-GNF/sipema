<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Pengaduan;
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
            PetugasSeeder::class,
            KategoriSeeder::class,
        ]);
        Pengaduan::factory()->count(15)->create();
    }
}
