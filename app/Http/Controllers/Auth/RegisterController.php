<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Menangani permintaan registrasi pengguna baru
    public function register(Request $request)
    {
        // Validasi input dari form registrasi
        $request->validate([
            'name' => 'required|string|max:255', // nama wajib diisi
            'email' => 'required|string|email|max:255|unique:users', // email wajib unik
            'password' => 'required|confirmed|min:6', // password harus minimal 6 karakter dan dikonfirmasi
        ]);

        // Simpan user baru ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // enkripsi password
        ]);

        // Login user setelah registrasi berhasil
        Auth::login($user);

        // Redirect ke halaman utama setelah login
        return redirect('/');
    }
}
