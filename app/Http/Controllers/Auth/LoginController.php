<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menangani proses login
    public function login(Request $request)
    {
        // Ambil data email dan password dari form
        $credentials = $request->only('email', 'password');

        // Coba otentikasi pengguna
        if (Auth::attempt($credentials)) {
            // Jika berhasil, arahkan ke halaman yang diinginkan (default '/')
            return redirect()->intended('/');
        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return back()->withErrors(['email' => 'Invalid credentials and .'])->withInput();
    }

    // Menangani proses logout
    public function logout(Request $request)
    {
        Auth::logout(); // Hapus sesi login
        return redirect('/login'); // Arahkan ke halaman login
    }
}
