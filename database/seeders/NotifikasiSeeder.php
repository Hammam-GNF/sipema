<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class NotifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $userIds = DB::table('users')->where('role', 'user')->pluck('id_user')->toArray();
        $pengaduanIds = DB::table('pengaduan')->pluck('id_pengaduan')->toArray();

        $notifikasi = [];

        for ($i = 1; $i <= 20; $i++) {
            $id_user = $faker->randomElement($userIds);
            $id_pengaduan = $faker->randomElement($pengaduanIds);

            $notifikasi[] = [
                'id_user' => $id_user,
                'id_pengaduan' => $id_pengaduan,
                'pesan' => $faker->sentence,
                'status_baca' => $faker->boolean,
                'tanggal_kirim' => $faker->dateTimeThisYear(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('notifikasi')->insert($notifikasi);
    }
}
