<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\BookingVehicle;

class BookingController extends Controller
{
    /**
     * Handle booking confirmation and upload payment proof.
     */
    public function confirm(Request $request)
    {
        $data = $request->validate([
            'ticket_stock_id' => 'required|integer',
            'departure_date' => 'nullable|date',
            'departure_time' => 'nullable|string',
            'dewasa_count' => 'nullable|integer|min:0',
            'anak_count' => 'nullable|integer|min:0',
            // support arrays for multiple vehicles while keeping legacy single fields
            'vehicle_types' => 'nullable|array',
            'vehicle_types.*' => 'nullable|string',
            'vehicle_counts' => 'nullable|array',
            'vehicle_counts.*' => 'nullable|integer|min:0',
            'vehicle_type' => 'nullable|string',
            'vehicle_count' => 'nullable|integer|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // store uploaded file to public disk
        $path = $request->file('payment_proof')->store('payments', 'public');

        // Create booking record
        $user = Auth::user();
        $booking = Booking::create([
            'user_id' => $user ? $user->id : null,
            'ticket_stock_id' => $request->input('ticket_stock_id'),
            'departure_date' => $request->input('departure_date'),
            'departure_time' => $request->input('departure_time'),
            'dewasa_count' => (int) $request->input('dewasa_count', 0),
            'anak_count' => (int) $request->input('anak_count', 0),
            'total_price' => $request->input('total_price', 0),
            'payment_proof_path' => $path,
            'status' => 'pending',
        ]);

        // Save booked vehicles (if any)
        $vehicleTypes = (array) $request->input('vehicle_types', []);
        $vehicleCounts = (array) $request->input('vehicle_counts', []);
        $vehiclePrices = (array) $request->input('vehicle_prices', []);
        foreach ($vehicleTypes as $i => $vt) {
            $cnt = (int) ($vehicleCounts[$i] ?? 0);
            $unit = floatval($vehiclePrices[$i] ?? 0);
            if ($cnt <= 0) continue;
            BookingVehicle::create([
                'booking_id' => $booking->id,
                'vehicle_type' => $vt,
                'count' => $cnt,
                'unit_price' => $unit,
                'total_price' => $cnt * $unit,
            ]);
        }

        return redirect()->route('book_ticket')
            ->with('success', 'Pemesanan berhasil dibuat. Silakan lanjutkan pembayaran.')
            ->with('payment_path', $path)
            ->with('booking_id', $booking->id);
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
