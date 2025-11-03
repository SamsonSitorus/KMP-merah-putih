<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        User::create([
            'name' => 'customer',
            'email' => 'customer@gmail.com',
            'role' => 'customer',
            'password' => bcrypt('customer123'),
        ]);
    }
}
