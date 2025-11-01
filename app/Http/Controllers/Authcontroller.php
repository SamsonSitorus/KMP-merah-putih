<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;

class Authcontroller extends Controller
{

    public function register(Request $request){
        // Ambil data JSON dari frontend
            $data = $request->all();

            // Cek dulu apakah user sudah ada di tabel `users`
            $existingUser = User::where('firebase_uid', $data['uid'])->first();
            if ($existingUser) {
                return response()->json([
                    'message' => 'User sudah terdaftar di Laravel',
                    'data' => $existingUser
                ]);
            }

            // Simpan ke tabel users
              $user = User::create([
            'firebase_uid' => $data['uid'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => null,
        ]);

         return response()->json([
            'message' => 'User registered successfully',
            'data' => $user
        ]);
    }
     public function verifyFirebase(Request $request)
    {
        try {
            $factory = (new Factory)->withServiceAccount(base_path('resources/credential/credential_firebase.json'));
            $auth = $factory->createAuth();

            $idTokenString = $request->input('token');
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
            $uid = $verifiedIdToken->claims()->get('sub');

            $user = User::where('firebase_uid', $uid)->first();

            if (!$user) {
                return response()->json(['message' => 'User not found in Laravel DB'], 404);
            }

            // Bisa simpan session manual atau lanjut ke halaman dashboard
            // session(['user' => $user]);
            Auth::login($user);
            $request->session()->regenerate(); 
            return response()->json([
                'message' => 'Login success',
                'user' => $user
            ]);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Invalid or expired token'], 401);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

}
