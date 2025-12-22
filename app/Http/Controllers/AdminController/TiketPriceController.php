<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketPrice;

class TiketPriceController extends Controller
{
    public function index()
    {
        $passengerPrices = TicketPrice::whereNotNull('passenger_type')
            ->whereNull('vehicle_type')
            ->select('id', 'passenger_type', 'price')
            ->orderBy('id')
            ->get();

        // Data Vehicle
        $vehiclePrices = TicketPrice::whereNotNull('vehicle_type')
            ->whereNull('passenger_type')
            ->select('id', 'vehicle_type', 'price')
            ->orderBy('id')
            ->get();

        return view('admin.tiket.index', compact(
            'passengerPrices',
            'vehiclePrices'
        ));
    }
}
