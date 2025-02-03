<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $petugasIds = DB::table('petugas')->pluck('id_petugas')->toArray();
        $pengaduanIds = DB::table('pengaduan')->pluck('id_pengaduan')->toArray();

        $laporan = [];

        for ($i = 1; $i <= 20; $i++) {
            $id_petugas = $faker->randomElement($petugasIds);
            $id_pengaduan = $faker->randomElement($pengaduanIds);

            $laporan[] = [
                'id_petugas' => $id_petugas,
                'id_pengaduan' => $id_pengaduan,
                'isi_laporan' => $faker->paragraph,
                'tanggal_laporan' => $faker->dateTimeThisYear(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('laporan')->insert($laporan);
    }
}
