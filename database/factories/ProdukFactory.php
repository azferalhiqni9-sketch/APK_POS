<?php

namespace Database\Factories;

use App\Models\Jenis;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hargaBeli = $this->faker->numberBetween(10_000, 500_000);

        return [
            // Ambil ID User role Admin (role_id = 1), atau user acak
            'user_id' => User::where('role_id', 1)->inRandomOrder()->value('id') 
                         ?? User::inRandomOrder()->value('id') 
                         ?? User::factory(),

            // Ambil ID Jenis secara acak dari database
            'jenis_id' => Jenis::inRandomOrder()->value('id'),

            'foto' => 'produk/' . $this->faker->uuid . '.jpg',
            'nama' => $this->faker->words(3, true),
            'harga_beli' => $hargaBeli,
            'harga_jual' => $hargaBeli + $this->faker->numberBetween(5_000, 100_000),
            'stok' => $this->faker->numberBetween(1, 500),
        ];
    }
}