<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $path = 'public/photos/shares/Products';
        $dir = \Storage::path($path);
        if (file_exists($dir) && is_dir($dir)) {
            $files = \Storage::files($path);
            if (count($files) > 0) {
                $products = \DB::table('products')->pluck('id');

                foreach ($products as $product) {
                    \DB::table('product_images')->insert([
                        [
                            'product_id' => $product,
                            'image' => getenv('APP_URL') . '/storage/photos/shares/Products/' . basename($faker->randomElement($files)),
                        ], [
                            'product_id' => $product,
                            'image' => getenv('APP_URL') . '/storage/photos/shares/Products/' . basename($faker->randomElement($files)),
                        ], [
                            'product_id' => $product,
                            'image' => getenv('APP_URL') . '/storage/photos/shares/Products/' . basename($faker->randomElement($files)),
                        ], [
                            'product_id' => $product,
                            'image' => getenv('APP_URL') . '/storage/photos/shares/Products/' . basename($faker->randomElement($files)),
                        ], [
                            'product_id' => $product,
                            'image' => getenv('APP_URL') . '/storage/photos/shares/Products/' . basename($faker->randomElement($files)),
                        ], [
                            'product_id' => $product,
                            'image' => getenv('APP_URL') . '/storage/photos/shares/Products/' . basename($faker->randomElement($files)),
                        ],
                    ]);
                }
            }
        } 
    }
}
