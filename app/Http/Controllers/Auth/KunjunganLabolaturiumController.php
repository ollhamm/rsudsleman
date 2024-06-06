<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\KunjunganLabolaturium;
use App\Models\Pemeriksaan;

class KunjunganLabolaturiumController extends Controller
{
    public function showKunjunganForm(Request $request)
    {
        $query = KunjunganLabolaturium::with('pemeriksaan.patients.user');

        if ($request->has('name')) {
            $query->whereHas('pemeriksaan.patients.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->has('tanggal_kunjungan')) {
            $query->where('tanggal_kunjungan', 'like', '%' . $request->tanggal_kunjungan . '%');
        }

        if ($request->has('tanggal_selesai')) {
            $query->where('tanggal_selesai', $request->tanggal_selesai);
        }
    
        $kunjunganLabolaturium = $query->get();
        $pemeriksaan = Pemeriksaan::with('patients')->get();

        return view('auth.kunjungan_labolaturium', compact('kunjunganLabolaturium', 'pemeriksaan'));
    }
    
    
    
    

    // Create
   
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_pemeriksaan' => 'required',
            'tanggal_kunjungan' => 'required',
            'tanggal_selesai' => 'required',
            'EDTA' => 'nullable|string',
            'Serum' => 'nullable|string',
            'Citrate' => 'nullable|string',
            'Urine' => 'nullable|string',
            'Lainya' => 'nullable|string',
            'kondisi_sampel' => 'nullable|string',
        ]);
        KunjunganLabolaturium::create($validatedData);
        return redirect()->route('admin.kunjunganLabolaturium')->with('success', 'LAB Visit Successfully Created');
    }

    // edit
    public function edit($id)
    {
        $kunjungans = KunjunganLabolaturium::findOrFail($id);
        return view('auth.editKunjungan', compact('kunjungans'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_pemeriksaan' => 'required',
            'tanggal_kunjungan' => 'required',
            'tanggal_selesai' => 'required',
            'EDTA' => 'nullable|string',
            'Serum' => 'nullable|string',
            'Citrate' => 'nullable|string',
            'Urine' => 'nullable|string',
            'Lainya' => 'nullable|string',
            'kondisi_sampel' => 'nullable|string',
        ]);

        $kunjungan = KunjunganLabolaturium::findOrFail($id);
        $kunjungan->update($validatedData);
        return redirect()->route('admin.kunjunganLabolaturium')->with('success', 'LAB Visit Data Successfully Updated');
    }

    // delete
    public function destroy($id)
    {
        $kunjungan = KunjunganLabolaturium::findOrFail($id);
        $kunjungan->delete();

        return redirect()->route('admin.kunjunganLabolaturium')->with('success', 'LAB Visit Data Deleted Successfully');
    }

    // details
    // Show Details Pemeriksaan
    public function showKunjunganDetail($id)
    {
        // Ambil data pemeriksaan berdasarkan ID
        $kunjungan = KunjunganLabolaturium::with('pemeriksaan')->findOrFail($id);

        if ($kunjungan) {
            $nama_pasien = $kunjungan->pemeriksaan->nama;

            return view('auth.detailKunjungan', compact('kunjungan', 'nama_pasien'));
        } else {
            return redirect()->route('admin.kunjunganLabolaturium')->with('error', 'Data pemeriksaan tidak ditemukan.');
        }
    }

}
