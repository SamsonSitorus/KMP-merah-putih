<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    public function profile(){
        $user = Auth::user(); // ambil user login
        $detail = $user->detail; // relasi dari model User

        return view('user.profile', compact('user', 'detail'));
    }

        public function updateorcreate(Request $request, $id)
    {
        $user = Auth::user();
        $profile = User::findOrFail($id);

        if ($user->id != $id) {
                abort(403, 'Unauthorized action.');
            }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:10000',
            'tanggal_lahir' => 'required|date|before_or_equal:' . now()->subYears(18)->toDateString(),
            'gender' => 'required|in:Laki-laki,Perempuan',
            'jenis_id' => 'required|in:KTP,SIM,Paspor',
            'nomor_identitas' => 'required|string|max:25',
            'kota_asal' => 'required|string|max:100',
            'ZipCode' => 'required|string|max:10',
        ]);

        // Upload foto profil
        $path = null;
        if ($request->hasFile('foto_profil')) {
            if ($profile->detail && $profile->detail->foto_profil && Storage::disk('public')->exists($profile->detail->foto_profil)) {
                Storage::disk('public')->delete($profile->detail->foto_profil);
            }
            $path = $request->file('foto_profil')->store('profile_photos', 'public');
        }

        // Update data user utama
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->phone_number = $request->phone_number;
        $profile->save();

        // Update atau buat UserDetail
        UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                'foto_profil' => $path ?? ($profile->detail->foto_profil ?? null),
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_id' => $request->jenis_id,
                'gender' => $request->gender,
                'nomor_identitas' => $request->nomor_identitas,
                'kota_asal' => $request->kota_asal,
                'ZipCode' => $request->ZipCode,
            ]
        );

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

}
