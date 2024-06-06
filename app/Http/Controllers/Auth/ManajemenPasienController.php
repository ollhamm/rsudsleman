<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\User;
use App\Models\Reagensia;
use App\Models\Pemeriksaan;
use App\Models\DataCallcenter;
use App\Models\KunjunganLabolaturium;
use Illuminate\Support\Str;

class ManajemenPasienController extends Controller
{
    public function getTotalPatientsCount()
    {
        try {
            $totalPatients = Patient::count();
            return $totalPatients;
        } catch (\Exception $e) {
            return 0;
        }
    }

    // Home
    public function showHomeForm(Request $request)
    {
        $query = Patient::query();
        $reagensias = Reagensia::all();

        $patients = $query->get();
        $totalPatientsCount = $this->getTotalPatientsCount();

        return view('auth.home', compact('patients', 'totalPatientsCount', 'reagensias'));
    }

    // manajement pasien view
    public function showManajementForm(Request $request)
    {
        $query = Patient::with('user');

        if ($request->has('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->has('rujukan')) {
            $query->where('rujukan', 'like', '%' . $request->rujukan . '%');
        }

        if ($request->has('rm')) {
            $query->where('rm', 'like', '%' . $request->rm . '%');
        }
    
        $patients = $query->get();
        $defaultRM = $this->generateRMCode();
        $users = User::all();

        return view('auth.mpasient', compact('patients', 'defaultRM', 'users'));
    }
    
    

    // generate kode P00
    private function generateRMCode()
    {
        $latestRM = Patient::latest()->value('rm');
        if ($latestRM) {
            $code = Str::of($latestRM)->replace('S/', '');
            $nextNumber = (int) $code->__toString() + 1;
            return 'S/' . sprintf('%04d', $nextNumber);
        } else {
            return 'S/0001';
        }
    }


    // create pasien
    public function create()
    {
        $defaultRM = $this->generateRMCode();
        return view('auth.create', compact('defaultRM'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'rm' => 'required',
            'rujukan' => 'required',
            'jenis_asuransi' => 'required',
            'nomor_asuransi' => 'nullable|numeric',
            'status' => 'required',
        ]);
        Patient::create($validatedData);

        return redirect()->route('admin.mpasient')->with('success', 'The check has been made successfully!');
    }

    // edit pasien
    public function edit($id_pasien)
    {
        $patient = Patient::findOrFail($id_pasien);
        return view('auth.edit', compact('patient'));
    }

    public function update(Request $request, $id_pasien)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'rujukan' => 'required',
            'jenis_asuransi' => 'required',
            'nomor_asuransi' => 'nullable|numeric',
            'status' => 'required',
        ]);

        $patient = Patient::findOrFail($id_pasien);
        $patient->update($validatedData);

        return redirect()->route('admin.mpasient')->with('success', 'Data Patient Updated Successfully');
    }

    public function destroy($id_pasien)
    {
        // Hapus data kunjungan terkait dari tabel kunjungan_labolaturium
        KunjunganLabolaturium::whereHas('pemeriksaan', function ($query) use ($id_pasien) {
            $query->where('id_pasien', $id_pasien);
        })->delete();

        // Hapus data pemeriksaan terkait dari tabel pemeriksaan
        Pemeriksaan::where('id_pasien', $id_pasien)->delete();

        // Hapus data pasien dari database
        $patient = Patient::findOrFail($id_pasien);
        $patient->delete();

        return redirect()->route('admin.mpasient')->with('success', 'Patient Successfully Deleted');
    }

    // show datadiri dan pemeriksaan
    public function showPatientDetailsAndPemeriksaan($id_pasien)
    {
        $patient = Patient::findOrFail($id_pasien);
        $pemeriksaan = Pemeriksaan::where('id_pasien', $id_pasien)->first();

        if (!$pemeriksaan) {
            $pemeriksaanData = [
                'tanggalKunjunganLab' => null,
                'tanggalSelesaiLab' => null,
                'edtaValue' => false,
                'serumValue' => false,
                'citrateValue' => false,
                'urineValue' => false,
                'lainyaValue' => false,
                'kondisi_sampel' => null,
            ];
        } else {
            $tanggalKunjunganLab = KunjunganLabolaturium::where('id_pemeriksaan', $pemeriksaan->id_periksa)->value('tanggal_kunjungan');
            $tanggalSelesaiLab = KunjunganLabolaturium::where('id_pemeriksaan', $pemeriksaan->id_periksa)->value('tanggal_selesai');
            $edtaValue = KunjunganLabolaturium::where('id_pemeriksaan', $pemeriksaan->id_periksa)->value('EDTA');
            $serumValue = KunjunganLabolaturium::where('id_pemeriksaan', $pemeriksaan->id_periksa)->value('Serum');
            $citrateValue = KunjunganLabolaturium::where('id_pemeriksaan', $pemeriksaan->id_periksa)->value('Citrate');
            $urineValue = KunjunganLabolaturium::where('id_pemeriksaan', $pemeriksaan->id_periksa)->value('Urine');
            $lainyaValue = KunjunganLabolaturium::where('id_pemeriksaan', $pemeriksaan->id_periksa)->value('Lainya');
            $kondisi_sampel = KunjunganLabolaturium::where('id_pemeriksaan', $pemeriksaan->id_periksa)->value('kondisi_sampel');

            $pemeriksaanData = [
                'tanggalKunjunganLab' => $tanggalKunjunganLab,
                'tanggalSelesaiLab' => $tanggalSelesaiLab,
                'edtaValue' => $edtaValue,
                'serumValue' => $serumValue,
                'citrateValue' => $citrateValue,
                'urineValue' => $urineValue,
                'lainyaValue' => $lainyaValue,
                'kondisi_sampel' => $kondisi_sampel,
            ];
        }

        return view('auth.datadiri', compact('patient', 'pemeriksaan', 'pemeriksaanData'));
    }
}
