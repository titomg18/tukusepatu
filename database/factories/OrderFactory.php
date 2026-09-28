<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pembeli_id' => User::factory(),
            'tgl_order' => now(),
            'total_harga' => fake()->numberBetween(500000, 3500000),
            'status_order' => fake()->randomElement([
                'menunggu_bayar',
                'menunggu_konfirmasi',
                'diproses',
                'dikirim',
                'selesai',
                'dibatalkan',
            ]),
            'alamat_pengiriman' => fake()->address(),
            'bukti_bayar' => null,
        ];
    }
}
