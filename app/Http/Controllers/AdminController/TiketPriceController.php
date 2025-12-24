<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketPrice;
use App\Models\Tickettype;

class TiketPriceController extends Controller
{
    public function index()
    {
        $ticketPrices = TicketPrice::with('ticketType')
        ->orderBy('id')
        ->get();

        // 🔹 Ambil SEMUA ticket type
        $ticketTypes = TicketType::orderBy('id')->get();

        return view('admin.tiket.index', compact(
            'ticketPrices',
            'ticketTypes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'price' => 'required|integer|min:0',
            'passenger_type' => 'nullable|string',
        ]);

        TicketPrice::create([
            'ticket_type_id' => $request->ticket_type_id,
            'name' => $request->passenger_type,
            'price'          => $request->price,
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
