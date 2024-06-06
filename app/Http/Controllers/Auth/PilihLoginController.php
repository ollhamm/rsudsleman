<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PilihLoginController extends Controller
{
    public function showLoginOptions()
    {
        return view('auth.pilihLogin');
    }
}
