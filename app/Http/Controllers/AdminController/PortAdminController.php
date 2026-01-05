<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketStock;
use Illuminate\Support\Facades\DB;

class PortAdminController extends Controller
{
    public function index(){
        $ticketStocks = DB::table('ticket_stocks')
        ->join('ports as origin', 'ticket_stocks.origin_port_id', '=', 'origin.id')
        ->join('ports as destination', 'ticket_stocks.destination_port_id', '=', 'destination.id')
        ->select(
            'ticket_stocks.id',
            'origin.name as origin_name',
            'origin.code as origin_code',
            'destination.name as destination_name',
            'destination.code as destination_code',
            'ticket_stocks.departure_date',
            'ticket_stocks.departure_time',
            'ticket_stocks.stock_roda_4',
            'ticket_stocks.stock_roda_2',
            'ticket_stocks.stock_passenger'
        )
        ->orderBy('ticket_stocks.departure_date')
        ->orderBy('ticket_stocks.departure_time')
        ->get();
        return view("admin.ports.index", compact('ticketStocks'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'origin' => 'required',
            'destination' => 'required|different:origin',
            'departure_date' => 'required|date',
            'schedules' => 'required|array|min:1',
            'schedules.*.time' => 'required',
            'schedules.*.stock_roda_4' => 'required|integer|min:1',
            'schedules.*.stock_roda_2' => 'required|integer|min:1',
        ]);

        foreach ($request->schedules as $item) {
            TicketStock::create([
                'origin_port_id'      => $request->origin,
                'destination_port_id' => $request->destination,
                'departure_date'      => $request->departure_date,
                'departure_time'      => $item['time'],
                'stock_roda_4'        => $item['stock_roda_4'],
                'stock_roda_2'        => $item['stock_roda_2'],
                'stock_passenger'     => '100'
            ]);
        }

        return back()->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function destroy($id)
    {
        TicketStock::findOrFail($id)->delete();

        return back()->with('success', 'Jadwal berhasil dihapus');
    }

}