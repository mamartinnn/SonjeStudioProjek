<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered; // Event untuk proses pendaftaran
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman/form registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Menangani request registrasi user baru.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input form registrasi
        $request->validate([
            'name' => ['required', 'string', 'max:255'], // nama wajib diisi
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class], // email wajib unik dan valid
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // password wajib, dikonfirmasi, dan sesuai aturan default
        ]);

        // Membuat user baru dengan data validasi
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // enkripsi password
        ]);

        // Trigger event Registered (biasanya untuk verifikasi email)
        event(new Registered($user));

        // Login otomatis setelah berhasil registrasi
        Auth::login($user);

        // Redirect ke halaman home dengan pesan sukses
        return redirect()->route('home')->with('success', 'Registration successful! Welcome!.');
    }
}
