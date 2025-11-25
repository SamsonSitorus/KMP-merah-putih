<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketStock;
use App\Models\TicketPrice;

class TicketStockSeeder extends Seeder
{
    public function run()
    {
        // If no ticket stocks exist, create sample stocks.
        if (TicketStock::count() === 0) {
            $sampleStocks = [
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

            foreach ($sampleStocks as $data) {
                TicketStock::create($data);
            }
        }

        // Create default prices (idempotent)
        $vehicles = [
            ['vehicle_type' => 'Motor', 'price' => 20000],
            ['vehicle_type' => 'Mobil Sedan', 'price' => 100000],
            ['vehicle_type' => 'Mobil Box', 'price' => 150000],
            ['vehicle_type' => 'Mobil Truck', 'price' => 250000],
            ['vehicle_type' => 'Mobil SUV', 'price' => 300000],
        ];

        foreach (TicketStock::all() as $stock) {
            // Passenger prices
            TicketPrice::firstOrCreate(
                ['ticket_stock_id' => $stock->id, 'passenger_type' => 'Dewasa'],
                ['price' => 50000]
            );

            TicketPrice::firstOrCreate(
                ['ticket_stock_id' => $stock->id, 'passenger_type' => 'Anak-anak'],
                ['price' => 30000]
            );

            // Vehicle prices
            foreach ($vehicles as $vehicle) {
                TicketPrice::firstOrCreate(
                    ['ticket_stock_id' => $stock->id, 'vehicle_type' => $vehicle['vehicle_type']],
                    ['price' => $vehicle['price']]
                );
            }
        }
    }
}
