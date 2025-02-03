<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class PengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $userIds = DB::table('users')->where('role', 'petugas')->pluck('id_user')->toArray();
        $petugasIds = DB::table('petugas')->pluck('id_petugas')->toArray();

        $pengaduan = [];

        for ($i = 1; $i <= 25; $i++) {
            $id_user =$faker->randomElement($userIds);
            $id_petugas = $faker->randomElement($petugasIds);

            $pengaduan[] = [
                'id_user' => $id_user,
                'id_petugas' => $id_petugas,
                'judul_pengaduan' => $faker->sentence,
                'deskripsi' => $faker->paragraph,
                'bukti' => $faker->imageUrl(),
                'tanggal_pengaduan' => $faker->date(),
                'status' => $faker->randomElement(['Menunggu Verifikasi', 'Diproses', 'Selesai', 'Ditolak']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('pengaduan')->insert($pengaduan);
    }
    
}
