<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class OrderDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $orders = DB::table('orders')->get();
        foreach ($orders as $order) {
            for ($i = 0; $i <= rand(1, 3); $i++) {
                $product = $faker->randomElement(DB::table('products')->select('id', 'current_price')->get());
                DB::table('order_details')->insert([
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                    'price' => $product->current_price,
                    'quantity_ordered' => $faker->numberBetween(1, 3),
                ]);
            }
        }
    }
}
