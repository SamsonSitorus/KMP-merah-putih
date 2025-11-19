<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function find_ticket()
{
    if (!Auth::check()) {
        return redirect()->route('login')
            ->with('warning', 'Silakan login terlebih dahulu.');
    }

    $user = Auth::user();
    $detail = $user->detail;

    if (!$detail) {
        return redirect()->route('profile')
            ->with('info', 'Lengkapi profil Anda sebelum melanjutkan.');
    }

    $requiredFields = [
        'tanggal_lahir',
        'gender',
        'jenis_id',
        'nomor_identitas',
        'kota_asal',
        'ZipCode'
    ];

    foreach ($requiredFields as $field) {
        if (empty($detail->$field)) {
            return redirect()->route('profile')
                ->with('info', 'Lengkapi profil Anda sebelum melanjutkan.');
        }
    }

    return view('user.find_ticket');
}

}
