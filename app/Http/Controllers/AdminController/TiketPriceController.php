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

    public function store(Request $request)
    {
        $request->validate([
            'type'            => 'required|in:passenger,vehicle',
            'price'           => 'required|numeric|min:0'
        ]);

        TicketPrice::create([
            'ticket_stock_id' => 1,
            'passenger_type'  => $request->type === 'passenger'
                                    ? $request->passenger_type
                                    : null,
            'vehicle_type'    => $request->type === 'vehicle'
                                    ? $request->vehicle_type
                                    : null,
            'price'           => $request->price
        ]);

        return redirect()->back()->with('success', 'Tiket berhasil dibuat');
    }


    public function update(Request $request)
    {
        $request->validate([
            'id'    => 'required|exists:ticket_prices,id',
            'type'  => 'required|in:passenger,vehicle',
            'price' => 'required|numeric|min:0'
        ]);

        $data = [
            'price' => $request->price,
        ];

        if ($request->type === 'passenger') {
            $data['passenger_type'] = $request->passenger_type;
            $data['vehicle_type'] = null; // 🔑 PENTING
        } else {
            $data['vehicle_type'] = $request->vehicle_type;
            $data['passenger_type'] = null; // 🔑 PENTING
        }

        TicketPrice::where('id', $request->id)->update($data);

        return redirect()->back()->with('success', 'Tiket berhasil diperbarui');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:ticket_prices,id'
        ]);

        TicketPrice::where('id', $request->id)->delete();

        return redirect()->back()->with('success', 'Tiket berhasil dihapus');
    }
}
