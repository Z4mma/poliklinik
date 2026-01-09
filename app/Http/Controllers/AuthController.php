<?php

namespace App\Http\Controllers;

use App\Models\User;
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
                } else{
                    return redirect()->route('pasien.dashboard');
                } 

            }
            return back()->withErrors(['email'=> 'Email atau password Salah !']);        
        }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register (Request $request)
    {
        $request->validate([
            'nama' =>['required','string','max:255'],
            'alamat' => ['required','string','max:255'],
            'no_ktp' => ['required','string','max:30'],
            'no_hp' => ['required','string','max:20'],
            'email'=> ['required','string','email', 'max:255', 'unique:user,email'],
            'password'=> ['required','confirmed'],
        ]);

        if(User::where('no_ktp', $request->no_ktp)->exists()){
            return back()->withErrors(['no_ktp' => 'Nomor KTP sudah terdaftar!']);
        }

        $no_rm = date('Ymd').'_'.str_pad(
            User::where('no_rm', 'like', date('Ymd').'%')->count() + 1,
            3, '0',
            STR_PAD_LEFT
        );

        User::create([
            'nama' => $request->nama,
            'alamat'=> $request->alamat,
            'no_ktp'=> $request->no_ktp,
            'no_hp'=> $request->no_hp,
            'email'=> $request->email,
            'password' => Hash::$request->password,
            'role' => 'pasien',
        ]);
        

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function dokter()
    {
        $data = Poli::with('dokters')->get();
        return $data;
    }
}

