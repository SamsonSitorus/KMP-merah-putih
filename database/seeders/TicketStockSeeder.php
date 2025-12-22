<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketStock;
use App\Models\TicketPrice;

class TicketStockSeeder extends Seeder
{
    public function run()
    {
        /**
         * ==========================
         * TICKET STOCK
         * ==========================
         */
        if (TicketStock::count() === 0) {
            $stocks = [
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

            foreach ($stocks as $stock) {
                TicketStock::create($stock);
            }
        }

        /**
         * ==========================
         * HARGA PENUMPANG
         * ==========================
         */
        $passengers = [
            ['passenger_type' => 'Dewasa', 'price' => 13000],
            ['passenger_type' => 'Bayi',   'price' => 2000],
        ];

        /**
         * ==========================
         * HARGA KENDARAAN
         * ==========================
         */
        $vehicles = [
            ['vehicle_type' => 'Sepeda Dayung', 'price' => 13000],
            ['vehicle_type' => 'Sepeda Motor', 'price' => 25000],
            ['vehicle_type' => 'Becak / Sepeda Motor > 500 cc', 'price' => 50000],
            ['vehicle_type' => 'Mini Bus Roda 4', 'price' => 180000],
            ['vehicle_type' => 'Pick Up', 'price' => 190000],
            ['vehicle_type' => 'Bus Sedang Roda 4', 'price' => 240000],
            ['vehicle_type' => 'Kendaraan Barang Roda 4', 'price' => 250000],
        ];

        /**
         * ==========================
         * INSERT PRICES
         * ==========================
         */
        foreach (TicketStock::all() as $stock) {

            // Passenger prices
            foreach ($passengers as $p) {
                TicketPrice::firstOrCreate(
                    [
                        'ticket_stock_id' => $stock->id,
                        'passenger_type' => $p['passenger_type'],
                        'vehicle_type' => null,
                    ],
                    [
                        'price' => $p['price'],
                    ]
                );
            }

            // Vehicle prices
            foreach ($vehicles as $v) {
                TicketPrice::firstOrCreate(
                    [
                        'ticket_stock_id' => $stock->id,
                        'passenger_type' => null,
                        'vehicle_type' => $v['vehicle_type'],
                    ],
                    [
                        'price' => $v['price'],
                    ]
                );
            }
        }
    }
}
