<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $brand = $faker->randomElement(\DB::table('brands')->select('id', 'name')->get());
    $rand = rand(1, 100);
    if ($rand > 20) {
        $price = rand(1000, 10000);
    } elseif ($rand > 5 && $rand <= 20) {
        $price = rand(10000, 15000);
    } else {
        $price = rand(15000, 25000);
    }
    return [
        'brand_id' => $brand->id,
        'name' => $brand->name . ' ' . rand(100000, 999999),
        'product_code' => $brand->name . '_' . \Str::random(12),
        'slug' => \Str::random(16),
        'buy_price' => $price,
        'current_price' => $price - $faker->numberBetween(0, $price*rand(0, 4)/10),
        'quantity_in_stock' => $faker->numberBetween(0, 1000),
        'excerpt' => $faker->paragraphs(3, true),
        'description' => $faker->paragraphs(3, true),
    ];
});
