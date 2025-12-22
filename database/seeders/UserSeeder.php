<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // 🔹 ADMIN
            [
                'name'         => 'Admin',
                'email'        => 'admin@gmail.com',
                'phone_number' => '081234567890',
                'role'         => 'admin',
                'password'     => Hash::make('password'),
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],

            // 🔹 USER
            [
                'name'         => 'User Test',
                'email'        => 'user@gmail.com',
                'phone_number' => '089876543210',
                'role'         => 'customer',
                'password'     => Hash::make('password'),
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
        ]);
    }
}
