<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            'Kebersihan',
            'Kerusakan',
            'Keamanan',
            'Lingkungan',
            'Fasilitas',
            'Perawatan',
            'Pemeliharaan',
            'Kebakaran',
            'Bencana Alam',
            'Kecelakaan',
            'Kesehatan',
            'Keadaan Darurat',
            'Transportasi',
            'Kegiatan',
            'Pendidikan'
        ];

        $kategoriData = [];
        foreach ($kategori as $item) {
            $kategoriData[] = [
                'nama_kategori' => $item,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('kategori')->insert($kategoriData);
    }
}
