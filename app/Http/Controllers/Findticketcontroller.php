<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Port;
use App\Models\TicketStock;

class Findticketcontroller extends Controller
{
    public function findTickets(Request $request)
    {
        $originId        = $request->origin_port_id;
        $destinationId   = $request->destination_port_id;
        $departureDate   = $request->departure_date;
        $departureTime   = $request->departure_time;

        // Decode booking_items (aman dari null / string kosong)
        $bookingItems = json_decode($request->booking_items ?? '{}', true);


        $passengers = $bookingItems['passengers'] ?? [];
        $vehicles   = $bookingItems['vehicles'] ?? [];
        
        $ticketTypeIds = [];
    foreach ($vehicles as $vehicle) {
        if (!empty($vehicle['ticket_type_id'])) {
            $ticketTypeIds[] = $vehicle['ticket_type_id'];
        }
    }
    $ticketTypeIds = array_unique($ticketTypeIds); 

  
        // TOTAL JUMLAH
        $totalPassengers = collect($passengers)->sum('count');
        $totalVehicles   = collect($vehicles)->sum('count');

        // TOTAL HARGA
        $passengerTotal = collect($passengers)
            ->sum(fn ($p) => ($p['count'] ?? 0) * ($p['price'] ?? 0));

        $vehicleTotal = collect($vehicles)
            ->sum(fn ($v) => ($v['count'] ?? 0) * ($v['price'] ?? 0));

        $totalPrice = $passengerTotal + $vehicleTotal;

        // Data pelabuhan
        $origin      = $originId ? Port::find($originId) : null;
        $destination = $destinationId ? Port::find($destinationId) : null;

        // Cari stok tiket
        $results = TicketStock::searchByRoute(
            $originId,
            $destinationId,
            $departureDate,
            $departureTime
        );
        return view('user.find_ticket', compact(
            'results',
            'origin',
            'destination',
            'departureDate',
            'departureTime',
            'passengers',
            'vehicles',
            'totalPassengers',
            'totalVehicles',
            'passengerTotal',
            'vehicleTotal',
            'totalPrice',
            'ticketTypeIds'
        ));
    }
}
