<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    // Method untuk menampilkan halaman dashboard akun
    public function dashboard()
    {
        // Mengembalikan view dari folder layouts/account/dashboard.blade.php
        return view('layouts.account.dashboard');
    }
}
