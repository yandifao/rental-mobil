<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'address' => 'Jl. Admin',
                'no_telp' => '081234567890',
                'no_sim' => '1234567890',
                'role' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
            ],
            [
                'name' => 'User',
                'address' => 'Jl. User',
                'no_telp' => '081234567891',
                'no_sim' => '1234567891',
                'role' => 'user',
                'email' => 'user@gmail.com',
                'password' => bcrypt('user123'),
            ],
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
