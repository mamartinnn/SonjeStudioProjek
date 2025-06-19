<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Memperbarui password pengguna yang sedang login.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validasi input:
        // - password saat ini harus benar (current_password)
        // - password baru harus sesuai aturan dan terkonfirmasi
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Update password di database menggunakan hash bcrypt
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Kembali ke halaman sebelumnya dengan pesan status
        return back()->with('status', 'password-updated');
    }
}
