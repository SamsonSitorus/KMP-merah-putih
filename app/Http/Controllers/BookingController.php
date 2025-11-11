<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'vehicle_type' => 'nullable|string',
            'vehicle_count' => 'nullable|integer|min:0',
            'total_price' => 'nullable|numeric|min:0',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // store uploaded file to public disk
        $path = $request->file('payment_proof')->store('payments', 'public');

        // For now, we simply flash success and the stored path; in real app you would create a booking record
        return redirect()->route('book_ticket')->with('success', 'Bukti pembayaran berhasil diunggah.')->with('payment_path', $path);
    }
}
