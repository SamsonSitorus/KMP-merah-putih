<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\BookingPassenger;
use App\Models\BookingPessanger;
use App\Models\BookingVehicle;

class BookingController extends Controller
{
public function detail(Request $request)
{$data = $request->validate([
    'ticket_stock_id' => 'required|exists:ticket_stocks,id',
    'departure_date'  => 'nullable|date',
    'departure_time'  => 'nullable|string',
    'total_price'     => 'required|numeric|min:0',

    'passengers' => 'required|array',

    'passengers.*.names' => 'required|array',
    'passengers.*.names.*' => 'required|string|max:255',

    'passengers.*.genders' => 'required|array',
    'passengers.*.genders.*' => 'required|in:Laki-laki,Perempuan',

    'passengers.*.ages' => 'required|array',
    'passengers.*.ages.*' => 'required|integer|min:0|max:120',

    'vehicles' => 'nullable|array',
    'vehicles.*.vehicle_type' => 'required|string',

    'vehicles.*.vehicle_names' => 'required|array',
    'vehicles.*.vehicle_names.*' => 'required|string',

    'vehicles.*.vehicle_years' => 'required|array',
    'vehicles.*.vehicle_years.*' => 'required|integer|min:1900|max:' . date('Y'),

    'vehicles.*.plates' => 'required|array',
    'vehicles.*.plates.*' => 'required|string|max:20',
]);

    //  CEK LOGIN
    $user = Auth::user();
    if (!$user) {
        abort(403, 'User belum login');
    }

    //  CEK SESSION BOOKING
    if (session()->has('booking_id')) {
        $existing = Booking::find(session('booking_id'));
        if ($existing && $existing->status === 'pending') {
            return redirect()->route('book_ticket.confirm', $existing->id);
        }
        session()->forget('booking_id');
    }

    //  SIMPAN BOOKING
    $booking = Booking::create([
        'user_id'         => $user->id,
        'ticket_stock_id' => $data['ticket_stock_id'],
        'departure_date'  => $data['departure_date'],
        'departure_time'  => $data['departure_time'],
        'total_price'     => $data['total_price'],
        'status'          => 'pending',
        'booksource'      => 'web',
        'booker_name'     => $user->name,
    ]);

    //  SIMPAN PENUMPANG
    foreach ($data['passengers'] as $passengerGroup) {
        foreach ($passengerGroup['names'] as $i => $name) {
            BookingPassenger::create([
                'booking_id' => $booking->id,
                'name'       => $name,
                'age'        => $passengerGroup['ages'][$i],
                'gender'     => $passengerGroup['genders'][$i],
            ]);
        }
    }
    

    //  SIMPAN KENDARAAN (JIKA ADA)
    if (!empty($data['vehicles'])) {
    foreach ($data['vehicles'] as $vehicle) {
        foreach ($vehicle['plates'] as $i => $plate) {
            BookingVehicle::create([
                'booking_id'   => $booking->id,
                'vehicle_type' => $vehicle['vehicle_type'],
                'vehicle_name' => $vehicle['vehicle_names'][$i],
                'vehicle_year' => $vehicle['vehicle_years'][$i],
                'no_plat'      => strtoupper($plate),
                'count'        => 1,
                'category'     => $vehicle['vehicle_type'],
            ]);
        }
    }
}


    //  SIMPAN SESSION
    session(['booking_id' => $booking->id]);

    //  REDIRECT
    return redirect()->route('book_ticket.confirm', $booking->id);
}


    public function showPayment()
    {
        $booking = Booking::with('vehicles')
            ->findOrFail(session('booking_id'));

        return view('user.ticket_payment', compact('booking'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $booking = Booking::findOrFail(session('booking_id'));
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        $booking->update([
            'payment_proof_path' => $path,
            'status' => 'menunggu_persetujuan',
        ]);
        session()->forget('booking_id');
        return redirect()
            ->route('history.status', 'menunggu_persetujuan')
            ->with('message', 'Bukti pembayaran berhasil diunggah!');
    }
    public function cancel(Request $request)
    {
        $bookingId = session('booking_id');
        if (!$bookingId) {
            return redirect()->route('home')
                ->with('error', 'Tidak dapat membatalkan pesanan. Booking ID tidak ditemukan.');
        }
        $booking = Booking::findOrFail($bookingId);
        $booking->update([
            'status' => 'dibatalkan',
            'payment_proof_path' => null,
        ]);
        session()->forget('booking_id');
        return redirect()
            ->route('home')
            ->with('message', 'Pesanan berhasil dibatalkan.');
    }

   public function downloadTicket($id)
{
    $user = Auth::user();

    $booking = Booking::with([
        'user',
        'vehicles',
        'Pessanger',
        'ticketStock.originPort',
        'ticketStock.destinationPort'
    ])
    ->where('id', $id)
    ->where('user_id', $user->id)
    ->firstOrFail();

    return view('user.e_ticket', compact('booking'));
}

}