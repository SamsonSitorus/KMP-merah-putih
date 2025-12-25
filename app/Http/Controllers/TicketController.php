<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\TicketStock;
use App\Models\TicketPrice;
use Illuminate\Http\Request;
use Carbon\Carbon;

class   TicketController extends Controller
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
        public function getDepartureTimes(Request $request)
    {
        $request->validate([
            'origin_port_id'      => 'required|integer',
            'destination_port_id' => 'required|integer',
            'departure_date'      => 'required|date',
        ]);

        $cutOff = Carbon::now('Asia/Jakarta')->addMinutes(30);

        $query = TicketStock::where('origin_port_id', $request->origin_port_id)
            ->where('destination_port_id', $request->destination_port_id)
            ->whereDate('departure_date', $request->departure_date)
            ->where(function ($q) {
                $q->where('stock_passenger', '>', 0)
                ->orWhere('stock_roda_2', '>', 0)
                ->orWhere('stock_roda_4', '>', 0);
            });

        /**
         * 🔥 FILTER JAM — TANPA isToday()
         */
        $query->whereRaw(
            "STR_TO_DATE(CONCAT(departure_date,' ',departure_time), '%Y-%m-%d %H:%i:%s') > ?",
            [$cutOff]
        );

        $times = $query
            ->orderBy('departure_time')
            ->pluck('departure_time')
            ->map(fn ($t) => substr($t, 0, 5));

        return response()->json($times);
    }

}
