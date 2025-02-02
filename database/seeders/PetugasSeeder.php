<?php

namespace Database\Seeders;

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
        $petugas = [];

        $adminName = 'Admin';
        $adminEmail = strtolower(str_replace(' ', '', $adminName)) . '@example.com';
        $petugas[] = [
            'name' => 'Admin',
            'email' => $adminEmail,
            'role' => 'Admin',
            'email_verified_at' => now(),
            'password' => Hash::make($adminEmail),
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => Str::random(10),
        ];

        for ($i = 1; $i <= 20; $i++) {
            $name = fake()->name();
            $formattedName = strtolower(str_replace([' ', '.', '\''], '', $name));
            $email = $formattedName . '@example.com';

            $petugas[] = [
                'name' => $name,
                'email' => $email,
                'role' => 'Petugas',
                'email_verified_at' => now(),
                'password' => Hash::make($email),
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ];
        }

        DB::table('petugas')->insert($petugas);
    }
}
