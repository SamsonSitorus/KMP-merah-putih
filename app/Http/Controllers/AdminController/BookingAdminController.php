<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingVehicle;
use Illuminate\Support\Facades\DB;

class BookingAdminController extends Controller
{
    public function index(){
        $orders = DB::table('bookings')
        ->join('users', 'bookings.user_id', '=', 'users.id')
        ->select(
            'bookings.id',
            'users.name as user_name',
            'users.email',
            'users.phone_number',
            'bookings.ticket_stock_id',
            'bookings.departure_date',
            'bookings.departure_time',
            'bookings.dewasa_count',
            'bookings.anak_count',
            'bookings.total_price',
            'bookings.payment_proof_path',
            'bookings.status',
            'bookings.created_at'
        )
        ->orderBy('bookings.created_at', 'desc')
        ->get();
    
        return view('admin.order.orderList', compact('orders'));
    }

    public function detail($id){

        $order = DB::table('bookings')
        ->join('users', 'bookings.user_id', '=', 'users.id')
        ->select(
            'bookings.id',
            'users.name as user_name',
            'users.email',
            'users.phone_number',
            'bookings.ticket_stock_id',
            'bookings.departure_date',
            'bookings.departure_time',
            'bookings.dewasa_count',
            'bookings.anak_count',
            'bookings.total_price',
            'bookings.payment_proof_path',
            'bookings.status',
            'bookings.created_at'
        )
        ->where('bookings.id', $id)
        ->first(); // ✅ SINGLE OBJECT

        $vehicles = DB::table('booking_vehicles')
        ->select(
            'id',
            'vehicle_type',
            'count',
            'unit_price',
            'total_price'
        )
        ->where('booking_id', $id)
        ->get();

        if (!$order) {
            abort(404);
        }

        return view('admin.order.detail_order', compact('order', 'vehicles'));

    }


    public function update($id){
        DB::table('bookings')
        ->where('id', $id)
        ->update([
            'status' => "berhasil",
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Status booking berhasil diperbarui');
    }
}
