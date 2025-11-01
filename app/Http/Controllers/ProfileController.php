<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ProfileController extends Controller
{
    public function profile(){
        $user = Auth::user(); // ambil user login
        $detail = $user->detail; // relasi dari model User

        return view('user.profile', compact('user', 'detail'));
    }
}
