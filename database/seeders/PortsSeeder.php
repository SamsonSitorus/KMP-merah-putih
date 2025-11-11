<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    {
        DB::table('ports')->insert([
            ['name' => 'Muara', 'code' => 'MR', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sipinggan', 'code' => 'SPG', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }    }
}
