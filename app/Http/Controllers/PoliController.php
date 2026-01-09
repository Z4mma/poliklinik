<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use Illuminate\Http\Request;
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
        'jadwal'=>$jadwal
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function submit()
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_poli' => 'required',
            'keterangan' => 'nullable',
        ]);

        Poli::create($validatedData);

        return redirect()->route('polis.index')->with('success', 'Poli berhasil ditambahkan.');
    }

    /**

     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $poli = Poli::findOrFail($id);
        return view('admin.poli.edit', compact('poli'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nama_poli' => 'required',
            'keterangan' => 'nullable',
        ]);

        $poli = Poli::findOrFail($id);
        $poli->update($validatedData);

        return redirect()->route('polis.index')->with('success', 'Poli berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $poli = Poli::findOrFail($id);
        $poli->delete($poli);

        return redirect()->route('polis.index')->with('success', 'Poli berhasil dihapus.');
    }
}
