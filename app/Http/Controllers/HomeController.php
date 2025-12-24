<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\TicketStock;
use App\Models\TicketPrice;
use App\Models\Tickettype;
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

        // Ambil semua jenis penumpang unik
        $passengerTypes = TicketStock::where('ticket_type_id', 1)
                            ->distinct()
                            ->pluck('ticket_type_id');
        // Ambil semua jenis kendaraan unik
        $vehicleTypes = TicketStock::whereIn('ticket_type_id', [1, 2])
                            ->distinct()
                            ->pluck('ticket_type_id');

        // ambil jam berdasarkan stok tiket
        // $jamKeberangkatan = Jadwal::where('port_asal', $portAsal)
        // ->where('port_tujuan', $portTujuan)
        // ->where('tanggal_keberangkatan', $tanggalKeberangkatan)
        // ->pluck('jam');  // ambil kolom jam saja


        // Ambil peta harga untuk kendaraan dan penumpang (ambil entri pertama per tipe sebagai default)
        $allPrices = TicketPrice::all();

        $vehiclePrices = $allPrices->whereNotNull('vehicle_type')
            ->groupBy('vehicle_type')
            ->map(function ($group) {
                return $group->first()->price;
            })
            ->toArray();

        $passengerPrices = $allPrices->whereNotNull('passenger_type')
            ->groupBy('passenger_type')
            ->map(function ($group) {
                return $group->first()->price;
            })
            ->toArray();

        // Kirim ke view user.home
        return view('user.home', compact(
            'ports',
            'ticketStocks',
            'passengerTypes',
            'vehicleTypes',
            'vehiclePrices',
            'passengerPrices'
        ));
    }

    /**
     * Ambil harga tiket otomatis berdasarkan asal, tujuan, dan jenis (penumpang / kendaraan)
     */
    public function getPrice(Request $request)
    {
        $origin = $request->origin_port_id;
        $destination = $request->destination_port_id;

        // Bisa salah satu: passenger_type atau vehicle_type
        $passengerType = $request->passenger_type;
        $vehicleType = $request->vehicle_type;

        // Query stok tiket berdasarkan asal dan tujuan
        $ticket = TicketStock::where('origin_port_id', $origin)
            ->where('destination_port_id', $destination)
            ->first();

        if (!$ticket) {
            return response()->json([
                'price' => null,
                'departure_time' => null,
                'remaining_stock' => null,
            ]);
        }

        // Ambil harga sesuai kategori
        $query = TicketPrice::where('ticket_stock_id', $ticket->id);

        if ($passengerType) {
            $query->where('passenger_type', $passengerType);
        }

        if ($vehicleType) {
            $query->where('vehicle_type', $vehicleType);
        }

        $price = $query->value('price');

        return response()->json([
            'price' => $price,
            'departure_time' => $ticket->departure_time,
            'remaining_stock' => $ticket->remaining_stock,
        ]);
    }
}
