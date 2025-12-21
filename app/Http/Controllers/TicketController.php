<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\TicketStock;
use App\Models\TicketPrice;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * 🔹 Menampilkan form tiket di halaman utama
     */
    public function index()
    {
        // Ambil semua pelabuhan (asal & tujuan)
        $ports = Port::all();

        // Ambil semua tipe penumpang dari tabel ticket_prices (bukan ticket_stocks)
        $passengerTypes = TicketPrice::select('passenger_type')->distinct()->get();

        // Kirim data ke view
        return view('user.home', compact('ports', 'passengerTypes'));
    }

    /**
     * 🔹 Ambil harga tiket otomatis berdasarkan asal, tujuan, dan jenis penumpang
     */
    public function getPrice(Request $request)
    {
        $origin = $request->origin_port_id;
        $destination = $request->destination_port_id;
        $passengerType = $request->passenger_type;

        // Ambil stok tiket berdasarkan asal & tujuan
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
