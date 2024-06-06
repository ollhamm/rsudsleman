<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Callcenter;
use Illuminate\Support\Facades\Hash;
use App\Models\DataCallcenter;

class CallcenterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.registerCallcenter');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:callcenters',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Callcenter::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'callcenter',
        ]);

        Auth::guard('callcenter')->login($user);

        return redirect()->route('callcenter.dashboard')->with('success', 'Account created successfully! You are now logged in.');
    }

    public function showLoginForm()
    {
        return view('auth.loginCallCenter');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('callcenter')->attempt($credentials)) {
            return redirect()->route('callcenter.dashboard')->with('success', 'Login successful.');
        }

        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'Email or password is incorrect.',
        ]);
    }

    public function destroy($id)
    {
        $instrumen = DataCallcenter::findOrFail($id);
        $instrumen->delete();

        return redirect()->route('callcenter.dashboard')->with('success', 'Patient has been removed from the queue');
    }

    public function showDataPatients()
    {
        $call = DataCallcenter::all();
        return view('auth.dashboardCallcenter', compact('call'));
    }

    public function logoutCallcenter(Request $request)
    {
        Auth::guard('callcenter')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('callcenter.login')->with('success', 'You have been logged out as callcenter.');
    }
}
