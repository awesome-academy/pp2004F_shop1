<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'title' => 'Unactived Member',
                'description' => 'Member who have not activate account',
            ],
            [
                'title' => 'Member',
                'description' => 'Default Member',
                'role_permission' => 2,
            ],
            [
                'title' => 'Super Admin',
                'description' => 'Super Admin who have all permissions',
                'role_permission' => 1,
            ],
        ];

        foreach ($roles as $role) {
            \DB::table('roles')->insert($role);
        }
    }
}
