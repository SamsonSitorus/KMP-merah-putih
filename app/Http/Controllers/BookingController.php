<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\BookingVehicle;
use App\Models\BookingPassengers;

class BookingController extends Controller
{
    public function detail(Request $request)
    {
        $data = $request->validate([
            'ticket_stock_id' => 'required|integer',
            'departure_date'  => 'nullable|date',
            'departure_time'  => 'nullable|string',
            'total_price'     => 'nullable|numeric|min:0',
            'vehicle_types'   => 'nullable|array',   
            'no_plat'         => 'nullable|array',   
            'passengers'      => 'nullable|array', 
        ]);
        $user = Auth::user();
        if (session()->has('booking_id')) {
            $existing = Booking::where('id', session('booking_id'))
                ->where('status', 'menunggu_pembayaran')
                ->first();
            if ($existing) {
                return redirect()->route('book_ticket.confirm', ['id' => $existing->id]);
            }
            session()->forget('booking_id');
        }
        $booking = Booking::create([
            'user_id'         => $user ? $user->id : null,
            'ticket_stock_id' => $data['ticket_stock_id'],
            'departure_date'  => $data['departure_date'],
            'departure_time'  => $data['departure_time'],
            'total_price'     => $data['total_price'],
            'status'          => 'menunggu_pembayaran',
            'booksource'      => 'online',
            'booker_name'     => $user ? $user->name : 'Guest',
        ]);
        if (!empty($data['vehicle_types'])) {

            foreach ($data['vehicle_types'] as $i => $type) {
                $platList = $data['no_plat'][$i] ?? [];
                if (strtolower($type) !== 'sepeda' && empty($platList)) {
                    return back()->withErrors([
                        "no_plat.$i" => "Nomor plat untuk kendaraan jenis $type wajib diisi."
                    ]);
                }
                foreach ($platList as $plat) {
                    BookingVehicle::create([
                        'booking_id'   => $booking->id,
                        'vehicle_type' => $type,
                        'no_plat'      => strtolower($type) === 'sepeda' ? null : $plat,
                    ]);
                }
            }
        }                                                   
        if (!empty($data['passengers'])) {
            foreach ($data['passengers'] as $category => $names) {
                foreach ($names as $name) {
                    BookingPassengers::create([
                        'booking_id' => $booking->id,
                        'name'       => $name,
                        'category'   => $category, 
                    ]);
                }
            }
        }
        session(['booking_id' => $booking->id]);
        return redirect()->route('book_ticket.confirm', ['id' => $booking->id]);
    }
    public function showPayment()
    {
        if (!session()->has('booking_id')) {
            return redirect()->route('home')->with('error', 'Booking tidak ditemukan.');
        }

        $booking = Booking::with('vehicles')->findOrFail(session('booking_id'));

        return view('user.ticket_payment', compact('booking'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if (!session()->has('booking_id')) {
            return redirect()->route('home')->with('error', 'Session booking sudah berakhir.');
        }

        $booking = Booking::findOrFail(session('booking_id'));

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $booking->update([
            'payment_proof_path' => $path,
            'status'             => 'menunggu_persetujuan',
        ]);

        session()->forget('booking_id');

        return redirect()
            ->route('history.status', 'menunggu_persetujuan')
            ->with('message', 'Bukti pembayaran berhasil diunggah!');
    }

    public function cancel()
    {
        if (!session()->has('booking_id')) {
            return redirect()->route('home')->with('error', 'Tidak ada booking yang bisa dibatalkan.');
        }

        $booking = Booking::findOrFail(session('booking_id'));

        $booking->update([
            'status' => 'dibatalkan',
            'payment_proof_path' => null,
        ]);

        session()->forget('booking_id');

        return redirect()->route('home')->with('message', 'Pesanan berhasil dibatalkan.');
    }

    public function downloadTicket($id)
    {
        $user = Auth::user();

        $booking = Booking::with(['user', 'vehicles'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('user.e_ticket', compact('booking'));
    }
}