<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileComplete
{
    /**
     * Handle an incoming request.
     * If user is not authenticated redirect to login; if profile incomplete, redirect to profile page.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Determine completeness: check if user has a detail record and required fields filled
        $detail = $user->detail;

        $required = ['tanggal_lahir', 'nomor_identitas', 'kota_asal'];

        $complete = true;
        if (! $detail) {
            $complete = false;
        } else {
            foreach ($required as $f) {
                if (empty($detail->{$f})) {
                    $complete = false;
                    break;
                }
            }
        }

        if (! $complete) {
            // flash a message and redirect to profile edit page
            return redirect()->route('profile')->with('warning', 'Lengkapi data profil Anda sebelum melakukan pemesanan tiket.');
        }

        return $next($request);
    }
}
