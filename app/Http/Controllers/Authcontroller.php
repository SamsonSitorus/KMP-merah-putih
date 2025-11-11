<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\password;

class Authcontroller extends Controller
{
    public function login(Request $request){
                $request->validate([
                'email' => 'required|email|max:50',
                'password' => 'required|min:3|max:50',
            ]);
            if(Auth::attempt($request->only('email', 'password'), $request->remember)){
                return redirect('/dashboard');
            }
            return back()->with('failed','Email atau password tidak sesuai !');
        }
}
