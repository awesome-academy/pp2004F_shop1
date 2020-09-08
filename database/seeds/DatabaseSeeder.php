<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class)
            ->call(UserSeeder::class)
            ->call(BrandSeeder::class)
            ->call(ProductSeeder::class)
            ->call(OrderSeeder::class)
            ->call(OrderDetailsSeeder::class)
            ->call(BillSeeder::class)
            ->call(ProductImageSeeder::class)
            ->call(CommentSeeder::class)
            ->call(RoleSeeder::class)
            ->call(PermissionSeeder::class)
            ;
    }
}
