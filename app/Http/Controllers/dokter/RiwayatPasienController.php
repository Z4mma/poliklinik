<?php

namespace App\Http\Controllers\dokter;

use App\Models\Periksa;
use Illuminate\Http\Request;

class RiwayatPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $riwayatPasien = Periksa::with([
            'daftarPoli.pasien',
            'daftarPoli.jadwalPeriksa.dokter',
            'detailPeriksas.obat'
        ])->orderBy('tgl_periksa', 'desc')->get();

        return view('dokter.riwayat-pasien.index', compact('riwayatPasien'));
    }

    public function show(string $id)
    {
        $periksa = Periksa::with([
            'daftarPoli.pasien',
            'daftarPoli.jadwalPeriksa.dokter',
            'detailPeriksas.obat'
        ])->findOrFail($id);

        return view('riwayat-pasien.show', compact('periksa'));
    }
}