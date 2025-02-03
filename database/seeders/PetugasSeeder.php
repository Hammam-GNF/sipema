<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanList = [
            'Kepala Dinas',
            'Sekretaris Daerah',
            'Bendahara Pengeluaran',
            'Kepala Sub Bagian',
            'Petugas Keamanan',
            'Staf Administrasi Umum',
            'Operator Sistem Informasi',
            'Petugas Kesehatan',
            'Petugas Sosial',
            'Petugas Keuangan'
        ];

        $jabatanCount = count($jabatanList);

        $users = User::where('role', 'petugas')->get();

        $petugas = [];

        foreach ($users as $index => $user) {
            $jabatan = $jabatanList[$index % $jabatanCount];

            $petugas[] = [
                'id_user' => $user->id_user,
                'jabatan' => $jabatan,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('petugas')->insert($petugas);
    }
}
