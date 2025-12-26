<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\BookingVehicle;

class BookingController extends Controller
{
    public function detail(Request $request)
    {
        $data = $request->validate([
            'ticket_stock_id' => 'required|integer',
            'departure_date' => 'nullable|date',
            'departure_time' => 'nullable|string',
            'dewasa_count' => 'nullable|integer|min:0',
            'anak_count' => 'nullable|integer|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'vehicle_types' => 'nullable|array',
            'vehicle_counts' => 'nullable|array',
        ]);
        $user = Auth::user();
        if (session()->has('booking_id')) {
            $existing = Booking::find(session('booking_id'));
            if ($existing && $existing->status === 'menunggu_pembayaran') {
                return redirect()->route('book_ticket.confirm', ['id' => $existing->id]);
            } 
            session()->forget('booking_id');
        }
        $booking = Booking::create([
            'user_id' => $user ? $user->id : null,
            'ticket_stock_id' => $data['ticket_stock_id'],
            'departure_date'  => $data['departure_date'],
            'departure_time'  => $data['departure_time'],
            'dewasa_count'    => $data['dewasa_count'],
            'anak_count'      => $data['anak_count'],
            'total_price'     => $data['total_price'],
            'status'          => 'menunggu_pembayaran',
        ]);
        if (!empty($request->vehicle_types)) {
            foreach ($request->vehicle_types as $index => $type) {
                BookingVehicle::create([
                    'booking_id' => $booking->id,
                    'vehicle_type' => $type,
                    'vehicle_count' => $request->vehicle_counts[$index] ?? 0,
                ]);
            }
        }
        session(['booking_id' => $booking->id]);
        return redirect()->route('book_ticket.confirm', ['id' => $booking->id]);
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

        $booking = Booking::with(['user', 'vehicles'])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('user.e_ticket', compact('booking'));
    }
}