<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
        {
            $credentials = $request->only('emai', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                # code...
                if ($user->role == 'admin') {
                    return redirect()->route('admin.dashboard');
                    # code...
                } elseif ($user->role == 'dokter') {
                    return redirect()->route('dokter.dashboard');
                } elseif ($user->role == 'pasien'){
                    return redirect()->route('pasien.dashboard');
                } 

            }
            return back()->withErrors(['email'=> 'Email atau password Salah !']);        
        }
            
}
