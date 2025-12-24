<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          DB::table('ticket_types')->insert([
            ['name' => 'Manusia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Motor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mobil', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
