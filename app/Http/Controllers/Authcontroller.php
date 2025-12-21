<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Authcontroller extends Controller
{

    /**
     * Register user received from Firebase
     *
     * @param \Illuminate\Http\Request $req
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uid' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|unique:users,phone_number',
        ],
         [
            'email.unique' => 'Email sudah terdaftar',
            'phone_number.unique' => 'Nomor telepon sudah terdaftar',
            'phone_number.required' => 'Nomor telepon wajib diisi',
            'email.required' => 'Email wajib diisi',
        ]);

        if ($validator->fails()) {  
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        if (User::where('firebase_uid', $request->uid)->exists()) {
            return response()->json([
                'message' => 'User sudah terdaftar'
            ], 409);
        }

        $user = User::create([
            'firebase_uid' => $request->uid,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => null,
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $user
        ], 201);
    }


    /**
     * Verify Firebase ID token and login the corresponding Laravel user
     *
     * @param \Illuminate\Http\Request $req
     */
    public function verifyFirebase(Request $req)
    {
        $request = $req;
        try {
            // ensure explicit instantiation with parentheses for clarity
            $factory = (new Factory())->withServiceAccount(base_path('resources/credential/credential_firebase.json'));
            $auth = $factory->createAuth();

            $idTokenString = $request->input('token');
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
            $uid = $verifiedIdToken->claims()->get('sub');

            $user = User::where('firebase_uid', $uid)->first();

            if (!$user) {
                return response()->json(['message' => 'User not found in Laravel DB'], 404);
            }

            // Login the user into Laravel session
            Auth::login($user);
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login success',
                'user' => $user
            ]);
        } catch (\Throwable $e) {
            // Log full exception for easier debugging (message + trace)
            Log::error('Firebase verify error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json(['message' => 'Invalid or expired token'], 401);
        }
    }
    /**
     * Logout the current user
     *
     * @param \Illuminate\Http\Request $req
     */
    public function logout(Request $req)
    {
        $request = $req;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

}