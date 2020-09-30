<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'status' => (rand(1, 100) > 15) ? 8 : rand(1, 9),
        'comment' => (rand(0, 100) < 10) ? $faker->paragraphs(3, true) : NULL,
        'customer_id' => $faker->randomElement(\DB::table('users')->pluck('id')),
        'ship_to_address' => (rand(0, 100) < 20) ? $faker->address : NULL,
        'created_at' => now()->subDays(rand(0, 120)),
    ];
});
