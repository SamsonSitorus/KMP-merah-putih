<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketStock;
use App\Models\TicketPrice;

class TicketStockSeeder extends Seeder
{
    public function run()
    {
        // Buat data TicketStock dulu
        $ticketStocks = [
            [
                'origin_port_id' => 1,
                'destination_port_id' => 2,
                'departure_date' => '2025-11-03',
                'departure_time' => '08:00:00',
                'total_stock' => 100,
                'remaining_stock' => 100,
            ],
            [
                'origin_port_id' => 2,
                'destination_port_id' => 1,
                'departure_date' => '2025-11-03',
                'departure_time' => '14:00:00',
                'total_stock' => 100,
                'remaining_stock' => 100,
            ],
        ];

        foreach ($ticketStocks as $data) {
            $stock = TicketStock::create($data);

            // Setelah stok dibuat, tambahkan harga tiketnya
            TicketPrice::create([
                'ticket_stock_id' => $stock->id,
                'passenger_type' => 'dewasa',
                'price' => 50000,
            ]);

            TicketPrice::create([
                'ticket_stock_id' => $stock->id,
                'passenger_type' => 'anak-anak',
                'price' => 30000,
            ]);
        }
    }
}