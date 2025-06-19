<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Menampilkan halaman konfirmasi password.
     * Halaman ini ditampilkan saat pengguna ingin melakukan tindakan sensitif
     * dan perlu memastikan identitasnya kembali.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Memverifikasi ulang password pengguna saat ini.
     * Jika password benar, simpan waktu konfirmasi ke session,
     * dan arahkan kembali ke tujuan yang diminta.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi bahwa password yang dimasukkan cocok dengan yang tersimpan di database
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            // Jika gagal, kembalikan pesan error
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        // Simpan waktu saat password berhasil dikonfirmasi
        $request->session()->put('auth.password_confirmed_at', time());

        // Redirect ke halaman yang dimaksud
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
