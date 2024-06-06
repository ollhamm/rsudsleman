<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Pemeriksaan;
use App\Models\KunjunganLabolaturium;
use Illuminate\Support\Str;

class PemeriksaanController extends Controller
{
    public function showPemeriksaanForm(Request $request)
    {
        $query = Pemeriksaan::with('patients');


        if ($request->has('name')) {
            $query->whereHas('patients.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }
        
        if ($request->has('rujukan')) {
            $query->where('rujukan_pemeriksaan', 'like', '%' . $request->rujukan . '%');
        }
        if ($request->has('tanggal_pemeriksaan')) {
            $query->where('tanggal_pemeriksaan', $request->tanggal_pemeriksaan);
        }

        $pemeriksaans = $query->get();


        $pemeriksaan = Patient::all();
        return view('auth.pemeriksaan', compact('pemeriksaans', 'pemeriksaan'));
    }

    public function showHasilForm(Request $request)
    {
        $query = Pemeriksaan::with('patients');


        if ($request->has('name')) {
            $query->whereHas('patients.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->has('rujukan')) {
            $query->where('rujukan_pemeriksaan', 'like', '%' . $request->rujukan . '%');
        }
        if ($request->has('tanggal_pemeriksaan')) {
            $query->where('tanggal_pemeriksaan', $request->tanggal_pemeriksaan);
        }

        $pemeriksaans = $query->get();


        $pemeriksaan = Patient::all();
        return view('auth.HasilPemeriksaan', compact('pemeriksaans', 'pemeriksaan'));
    }
 

 
    public function create()
    {
        $pemeriksaan = Patient::all();
        return view('auth.createPemeriksaan', compact('pemeriksaan', 'defaultRM', 'defaultIN'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pasien' => 'required',
            'tanggal_pemeriksaan' => 'required',
            'amnesis_dokter' => 'required',
            'unit_pemeriksaan' => 'required',
            'verifikator' => 'required',
            'rujukan_pemeriksaan' => 'required',
            'jenis_pembayaran' => 'required',
            'payment' => 'nullable|numeric|between:0,9999999999.99',
            'payment_status' => 'required|string',
            'WBC' => 'nullable|numeric',
            'RBC' => 'nullable|numeric',
            'PLT' => 'nullable|numeric',
            'HGB' => 'nullable|numeric',
            'HTM' => 'nullable|numeric',
            'Neu' => 'nullable|numeric',
            'Eos' => 'nullable|numeric',
            'Bas' => 'nullable|numeric',
            'Lym' => 'nullable|numeric',
            'Mon' => 'nullable|numeric',
            'MCV' => 'nullable|numeric',
            'MCH' => 'nullable|numeric',
            'MCHC' => 'nullable|numeric',
        ]);
    
        Pemeriksaan::create($validatedData);
        return redirect()->route('admin.pemeriksaan')->with('success', 'Patient examination data Created is successfully');
    }
    

    // edit pemeriksaan
    public function edit($id_periksa)
    {
        $pemeriksaans = Pemeriksaan::findOrFail($id_periksa);
        return view('auth.editPemeriksaan', compact('pemeriksaans'));
    }
    public function update(Request $request, $id_periksa)
    {
        $validatedData = $request->validate([
            'id_pasien' => 'required',
            'tanggal_pemeriksaan' => 'required',
            'unit_pemeriksaan' => 'required',
            'verifikator' => 'required',
            'rujukan_pemeriksaan' => 'required',
            'jenis_pembayaran' => 'required',
            'payment' => 'nullable|numeric|between:0,9999999999.99',
            'payment_status' => 'required|string',
            'WBC' => 'nullable|numeric',
            'RBC' => 'nullable|numeric',
            'PLT' => 'nullable|numeric',
            'HGB' => 'nullable|numeric',
            'HTM' => 'nullable|numeric',
            'Neu' => 'nullable|numeric',
            'Eos' => 'nullable|numeric',
            'Bas' => 'nullable|numeric',
            'Lym' => 'nullable|numeric',
            'Mon' => 'nullable|numeric',
            'MCV' => 'nullable|numeric',
            'MCH' => 'nullable|numeric',
            'MCHC' => 'nullable|numeric',

        ]);

        $pemeriksaans = Pemeriksaan::findOrFail($id_periksa);
        $pemeriksaans->update($validatedData);

        return redirect()->route('admin.pemeriksaan')->with('success', 'Patient examination data Updated is successfully');
    }

    // Delete periksa
    public function destroy($id_periksa)
    {
        // Find the pemeriksaan record
        $pemeriksaans = Pemeriksaan::findOrFail($id_periksa);

        // Delete related records from kunjungan_labolaturium table
        KunjunganLabolaturium::where('id_pemeriksaan', $id_periksa)->delete();

        $pemeriksaans->delete();

        return redirect()->route('admin.pemeriksaan')->with('success', 'Check Successfully Deleted');
    }


    // Show Details Pemeriksaan
public function showPemeriksaanDetails($id_periksa)
{
    // Ambil data pemeriksaan berdasarkan ID
    $pemeriksaan = Pemeriksaan::with('patients')->findOrFail($id_periksa);

    // Jika pemeriksaan ditemukan
    if ($pemeriksaan) {
        // Ambil nama pasien dari relasi patients
        $nama_pasien = $pemeriksaan->patients->nama;

        // Kirim data pemeriksaan dan nama pasien ke view
        return view('auth.detailPemeriksaan', compact('pemeriksaan', 'nama_pasien'));
    } else {
        // Jika pemeriksaan tidak ditemukan, redirect atau tampilkan pesan error
        return redirect()->route('pemeriksaan')->with('error', 'Data pemeriksaan tidak ditemukan.');
    }
}
}
