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
        $orders = \DB::table('orders')->get();
        foreach ($orders as $order) {
            $max = (rand(1, 100) > 10) ? 1 : rand(2, 3);
            for ($i = 0; $i <= $max; $i++) {
                $product = $faker->randomElement(\DB::table('products')->select('id', 'current_price')->get());
                \DB::table('order_details')->insert([
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                    'price' => $product->current_price,
                    'quantity_ordered' => ($max == 1) ? 1 : rand(2, 3),
                ]);
            }
        }
    }
}
