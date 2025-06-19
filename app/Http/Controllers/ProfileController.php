<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil pengguna.
     */
    public function edit(Request $request): View
    {
        // Mengirimkan data user ke view edit profil
        return view('layouts.account.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update nama dan email dari input
        $user->fill($request->only(['name', 'email']));

        // Jika email diubah, tandai belum terverifikasi
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Jika ingin mengubah password, validasi dulu
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'], // Validasi password lama
                'new_password' => ['required', 'confirmed', 'min:8'],   // Password baru harus dikonfirmasi
            ], [
                'current_password.current_password' => 'The current password is incorrect.',
            ]);

            // Set password baru (terenkripsi)
            $user->password = bcrypt($request->new_password);
        }

        // Simpan perubahan ke database
        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    /**
     * Menghapus akun pengguna secara permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validasi password sebelum hapus akun
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Logout user sebelum akun dihapus
        Auth::logout();

        // Hapus akun user
        $user->delete();

        // Invalidasi session saat ini
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama
        return Redirect::to('/');
    }
}
