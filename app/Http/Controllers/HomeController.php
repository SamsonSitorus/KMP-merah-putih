<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\TicketStock;
use App\Models\TicketPrice;
use App\Models\Tickettype;
use Faker\Guesser\Name;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama beserta data pelabuhan, stok tiket, jenis penumpang, dan kendaraan
     */
    public function index()
    {
        // Ambil semua pelabuhan (asal & tujuan)
        $ports = Port::all();

        // Ambil semua stok tiket
        $ticketStocks = TicketStock::all();
          
        $passengerTypes = TicketPrice::where('ticket_type_id', 1)->get(['name', 'price']);
    
        // Contoh query ambil kendaraan (ticket_type_id 2 dan 3)
        $vehicleTypes = TicketPrice::whereIn('ticket_type_id', [2, 3])->get(['name', 'price', 'ticket_type_id']);
        // Kirim ke view user.home
        return view('user.home', compact(
            'ports',
            'ticketStocks',
            'passengerTypes',
            'vehicleTypes'
        ));
    }
    
}
