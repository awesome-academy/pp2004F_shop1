<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'All Permissions',
            'Default User',
            'Admin Policy' => [
                'Manage Admin Role',
                'Access Admin System',
                'View Admin List',
                'View Admin Details',
                'Active Admin',
                'Ban/Restore Admin',
                'Delete Admin',
            ],
            'User Management Policy' => [
                'View User List',
                'View User Details',
                'Active User',
                'Ban/Restore User',
                'Delete User',
            ],
            'Product Policy' => [
                'View Product List',
                'View Product Details',
                'Create New Product',
                'Update Product',
            ],
            'Order Policy' => [
                'View Order List',
                'View Order Details',
                'Update Order As Shipper',
                'Update Order As Admin',
            ],
            'Bill Policy' => [
                'View Bill List',
                'View Bill Details',
            ],
            'Brand Policy' => [
                'View Brand List',
                'View Brand Details',
                'Create New Brand',
                'Update Brand',
                'Delete Brand',
            ],
        ];
        $index = $group = 0;
        foreach ($permissions as $key => $value) {
            if (is_array($value)) {
                $index++;
                \DB::table('permissions')->insert([
                    'title' => $key,
                ]);
                $group = $index;
                foreach ($value as $permission) {
                    \DB::table('permissions')->insert([
                        'title' => $permission,
                        'permission_group' => $group,
                    ]);
                    $index++;
                }
            } else {
                \DB::table('permissions')->insert([
                    'title' => $value,
                ]);
                $index++;
            }
        }
    }
}
