<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketPriceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ticket_prices')->insert([
            // PENUMPANG
            [
                'name' => 'Dewasa (Usia > 2 tahun)',
                'ticket_type_id' => 1,
                'price' => 13000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bayi (Usia < 2 tahun)',
                'ticket_type_id' => 1,
                'price' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KENDARAAN RODA 2
            [
                'name' => 'Sepeda Dayung',
                'ticket_type_id' => 2,
                'price' => 13000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sepeda Motor',
                'ticket_type_id' => 2,
                'price' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Becak / Sepeda Motor >500cc',
                'ticket_type_id' => 2,
                'price' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // KENDARAAN RODA 4
            [
                'name' => 'Mini Bus Roda 4',
                'ticket_type_id' => 3,
                'price' => 180000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pick Up',
                'ticket_type_id' => 3,
                'price' => 190000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bus Sedang Roda 4',
                'ticket_type_id' => 3,
                'price' => 240000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kendaraan Barang Roda 4',
                'ticket_type_id' => 3,
                'price' => 250000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
