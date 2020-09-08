<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'email' => 'mai@email.com',
                'password' => \Hash::make('12345678'),
                'role_id' => 3,
                'remember_token' => Str::random(10),
                'first_name' => 'Mai',
                'last_name' => 'Nguyen Nhu',
            ],
            [
                'email' => 'member@email.com',
                'password' => \Hash::make('87654321'),
                'role_id' => 2,
                'remember_token' => Str::random(10),
                'first_name' => 'Huy',
                'last_name' => 'Bui',
            ],
        ];
        foreach($admins as $admin) {
            DB::table('users')->insert([
                'email' => $admin['email'],
                'password' => $admin['password'],
                'activated_at' => now(),
                'role_id' => $admin['role_id'],
                'remember_token' => $admin['remember_token'],
                'first_name' => $admin['first_name'],
                'last_name' => $admin['last_name'],
            ]);
        }
    }
}
