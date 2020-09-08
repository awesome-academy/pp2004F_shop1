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
        $path = public_path('storage/photos/shares/Products');
        if (file_exists($path) && is_dir($path)) {
            $all = \File::allFiles($path);
            if (count($all) > 0) {
                $files = [];
                $products = \DB::table('products')->pluck('id');

                foreach ($all as $file) {
                    if (! \Str::endsWith(dirname($file->getPathName()), 'thumbs')) {
                        array_push($files, $file);
                    }
                }
                foreach ($products as $product) {
                    \DB::table('product_images')->insert([
                        [
                            'product_id' => $product,
                            'image' => 'http://localhost:8000/storage/photos/shares/Products/' . $faker->randomElement($files)->getFileName(),
                        ], [
                            'product_id' => $product,
                            'image' => 'http://localhost:8000/storage/photos/shares/Products/' . $faker->randomElement($files)->getFileName(),
                        ], [
                            'product_id' => $product,
                            'image' => 'http://localhost:8000/storage/photos/shares/Products/' . $faker->randomElement($files)->getFileName(),
                        ], [
                            'product_id' => $product,
                            'image' => 'http://localhost:8000/storage/photos/shares/Products/' . $faker->randomElement($files)->getFileName(),
                        ], [
                            'product_id' => $product,
                            'image' => 'http://localhost:8000/storage/photos/shares/Products/' . $faker->randomElement($files)->getFileName(),
                        ], [
                            'product_id' => $product,
                            'image' => 'http://localhost:8000/storage/photos/shares/Products/' . $faker->randomElement($files)->getFileName(),
                        ],
                    ]);
                }
            }
        } 
    }
}
