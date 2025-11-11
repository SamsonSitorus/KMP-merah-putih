<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketStock;
use App\Models\TicketPrice;

class TicketStockSeeder extends Seeder
{
    public function run()
    {
        // Buat data stok tiket
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

            //  Harga penumpang
            TicketPrice::create([
                'ticket_stock_id' => $stock->id,
                'passenger_type' => 'Dewasa',
                'price' => 50000,
            ]);

            TicketPrice::create([
                'ticket_stock_id' => $stock->id,
                'passenger_type' => 'Anak-anak',
                'price' => 30000,
            ]);

            //  Harga kendaraan
            $vehicles = [
                ['vehicle_type' => 'Motor', 'price' => 20000],
                ['vehicle_type' => 'Mobil Sedan', 'price' => 100000],
                ['vehicle_type' => 'Mobil Box', 'price' => 150000],
                ['vehicle_type' => 'Mobil Truck', 'price' => 250000],
                ['vehicle_type' => 'Mobil SUV', 'price' => 300000],
            ];

            foreach ($vehicles as $vehicle) {
                TicketPrice::create([
                    'ticket_stock_id' => $stock->id,
                    'vehicle_type' => $vehicle['vehicle_type'],
                    'price' => $vehicle['price'],
                ]);
            }
        }
    }
}
