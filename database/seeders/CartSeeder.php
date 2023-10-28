<?php

namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carts = [
            [
                'name' => 'Chocolate Donut',
                'price' => 10.99,
                'quantity' => 10,
            ],
            [
                'name' => 'Cheese Cake',
                'price' => 19.99,
                'quantity' => 5,
            ],
            [
                'name' => 'Nutella Bread',
                'price' => 5.99,
                'quantity' => 20,
            ],
        ];

        foreach ($carts as $cart) {
            Cart::create($cart);
        }
    }
}
