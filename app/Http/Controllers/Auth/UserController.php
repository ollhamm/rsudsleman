<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\KunjunganLabolaturium;
use App\Models\Patient;

class UserController extends Controller
{
    // Register
    public function showRegisterForm()
    {
        return view('auth.registerUser');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.login')->with('success', 'Registrasi berhasil!');
    }

    // Login
    public function showLoginForm()
    {
        return view('auth.loginUser');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            $request->session()->put('user_name', $user->name);

            return redirect()->route('user.dashboard');
        }

        return redirect()->route('user.login')->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Tambahkan header untuk mencegah caching halaman dashboard
        return redirect()->route('pilihLogin')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, max-age=0, must-revalidate',
            'Pragma' => 'no-cache',
        ]);
    }

    public function showDashboardForm()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->first();

        if ($patient) {
            $pemeriksaan = $patient->pemeriksaan()->where('id_pasien', $patient->id_pasien)->first();
            $hasilPemeriksaan = $pemeriksaan ? $pemeriksaan->hasil_pemeriksaan : [];

            $pemeriksaanData = [];
            if ($pemeriksaan) {
                $kunjunganLabData = KunjunganLabolaturium::where('id_pemeriksaan', $pemeriksaan->id_periksa)->first();
                if ($kunjunganLabData) {
                    $pemeriksaanData = [
                        'tanggalKunjunganLab' => $kunjunganLabData->tanggal_kunjungan,
                        'tanggalSelesaiLab' => $kunjunganLabData->tanggal_selesai,
                        'edtaValue' => $kunjunganLabData->EDTA,
                        'serumValue' => $kunjunganLabData->Serum,
                        'citrateValue' => $kunjunganLabData->Citrate,
                        'urineValue' => $kunjunganLabData->Urine,
                        'lainyaValue' => $kunjunganLabData->Lainya,
                        'kondisi_sampel' => $kunjunganLabData->kondisi_sampel,
                    ];
                }
            }
            $tanggalSelesaiLab = isset($pemeriksaanData['tanggalSelesaiLab']) ? $pemeriksaanData['tanggalSelesaiLab'] : null;

            return view('auth.dashboard', compact('user', 'patient', 'pemeriksaan', 'hasilPemeriksaan', 'pemeriksaanData'));
        } else {
            return view('auth.dashboard', compact('user', 'patient'));
        }
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi data
        $validatedData = $request->validate([
            'tempat_lahir' => 'nullable|string|max:255',
            'jenis_kelamin_user' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update data profil pengguna
        $user->tempat_lahir = $validatedData['tempat_lahir'];
        $user->address = $validatedData['address'];
        $user->jenis_kelamin_user = $validatedData['jenis_kelamin_user'];

        if ($request->hasFile('profilePicture')) {
            $profilePicture = $request->file('profilePicture');
            $profilePictureName = $user->name . '_' . time() . '.' . $profilePicture->getClientOriginalExtension();
            $profilePicturePath = $profilePicture->storeAs('profile_pictures', $profilePictureName, 'public');
            $user->profile_picture = $profilePictureName;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

}
