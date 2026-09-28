<?php

namespace Database\Factories;

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
        return [
            'penjual_id' => User::factory(),
            'nama_product' => fake()->randomElement(['Nike Air Max 270', 'Adidas Ultraboost 5.0', 'Puma RS-X', 'Converse Chuck Taylor', 'Vans Old Skool']),
            'deskripsi' => fake()->paragraph(),
            'harga' => fake()->numberBetween(500000, 2500000),
            'stok' => fake()->numberBetween(1, 50),
            'kategori' => fake()->randomElement(['Sneakers', 'Running', 'Casual', 'Formal', 'Boots']),
            'gambar_product' => null,
            'status_product' => fake()->randomElement(['tersedia', 'habis']),
        ];
    }
}
