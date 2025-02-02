<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Models\Petugas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengaduan>
 */
class PengaduanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pengaduan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id_petugas' => Petugas::inRandomOrder()->first()->id_petugas,
            'id_kategori' => Kategori::inRandomOrder()->first()->id_kategori,
            'deskripsi' => $this->faker->text(200),
            'status' => $this->faker->randomElement(['terbuka', 'proses', 'selesai']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
