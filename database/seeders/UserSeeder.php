<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];

        // Admin
        $adminName = 'admin';
        $adminEmail = strtolower(str_replace(' ', '', $adminName)) . '@example.com';
        $password = 'password';
        $users[] = [
            'name' => $adminName,
            'email' => $adminEmail,
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'created_at' => now(),
            'updated_at' => now(),
            'remember_token' => Str::random(10),
        ];

        // User
        for ($i = 1; $i <= 20; $i++) {
            $name = fake()->name();
            $formattedName = strtolower(str_replace([' ', '.', '\''], '', $name));
            $email = $formattedName . '@example.com';

            $users[] = [
                'name' => $name,
                'email' => $email,
                'role' => 'user',
                'email_verified_at' => now(),
                'password' => Hash::make($email),
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ];
        }

        // Petugas
        for ($i = 1; $i <= 10; $i++) {
            $name = fake()->name();
            $formattedName = strtolower(str_replace([' ', '.', '\''], '', $name));
            $email = $formattedName . '@example.com';

            $users[] = [
                'name' => $name,
                'email' => $email,
                'role' => 'petugas',
                'email_verified_at' => now(),
                'password' => Hash::make($email),
                'created_at' => now(),
                'updated_at' => now(),
                'remember_token' => Str::random(10),
            ];
        }

        DB::table('users')->insert($users);
    }
}
