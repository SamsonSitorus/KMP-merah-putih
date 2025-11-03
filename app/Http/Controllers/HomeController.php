<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\TicketStock;
use App\Models\TicketPrice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * 🔹 Menampilkan halaman utama beserta data pelabuhan, stok tiket, dan jenis penumpang
     */
    public function index()
    {
        // Ambil semua pelabuhan (asal & tujuan)
        $ports = Port::all();

        // Ambil semua stok tiket
        $ticketStocks = TicketStock::all();

        // Ambil semua jenis penumpang unik dari tabel ticket_prices
        $passengerTypes = TicketPrice::select('passenger_type')->distinct()->get();

        // Ambil daftar harga unik (opsional)
        $prices = TicketPrice::select('price')->distinct()->pluck('price');

        // Kirim ke view user.home
        return view('user.home', compact('ports', 'ticketStocks', 'passengerTypes', 'prices'));
    }

    /**
     * 🔹 Ambil harga tiket otomatis berdasarkan asal, tujuan, dan jenis penumpang
     */
    public function getPrice(Request $request)
    {
        $origin = $request->origin_port_id;
        $destination = $request->destination_port_id;
        $passengerType = $request->passenger_type;

        // Cari tiket berdasarkan asal dan tujuan
        $ticket = TicketStock::where('origin_port_id', $origin)
            ->where('destination_port_id', $destination)
            ->with(['prices' => function ($query) use ($passengerType) {
                $query->where('passenger_type', $passengerType);
            }])
            ->first();

        // Jika tiket dan harga ditemukan
        if ($ticket && $ticket->prices->isNotEmpty()) {
            return response()->json([
                'price' => $ticket->prices->first()->price,
                'departure_time' => $ticket->departure_time,
                'remaining_stock' => $ticket->remaining_stock,
            ]);
        }

        // Jika tidak ditemukan
        return response()->json([
            'price' => null,
            'departure_time' => null,
            'remaining_stock' => null,
        ]);
    }
}
