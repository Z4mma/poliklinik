<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get()
    {
        $user = Auth::user();
        $polis = Poli::all();
        $jadwal = JadwalPeriksa::with('dokter', 'dokter.poli')->get();
        
        return view('pasien.daftar',[
            'user'=>$user,
            'polis'=>$polis,
            'jadwals'=>$jadwal,
    
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'id_jadwal'=> 'required|exists:jadwal_periksas,id',
            'keluhan'=>'nullable|string',
            'id_pasien'=>'required|exists:users,id',

        ]);
        $jumlahSudahDaftar = DaftarPoli::where('id_jadwal', $request->id_jadwal)->count();
        $daftar = DaftarPoli::create([
            'id_jadwal'=> $request->id_jadwals,
            'id_pasien'=>$request->id_pasien,
            'keluhan'=>$request->keluhan,
            'no_antrian'=> $jumlahSudahDaftar + 1,
        ]);    
        return redirect()->back()->with('message', 'Berhasil mendaftar ke Poli>')->with('type', 'success');
    }
}
