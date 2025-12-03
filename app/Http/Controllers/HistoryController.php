<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\BookingVehicle;

class HistoryController extends Controller
{
    public function history($status = 'berhasil')
        {
            $user = Auth::user();
            $detail = $user->detail;
            $booking = Booking::where('user_id', $user->id)
                            ->where('status', $status)
                            ->orderBy('created_at', 'desc')
                            ->get();

            return view('user.history', compact('user', 'detail', 'booking', 'status'));
        }
}
