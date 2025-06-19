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
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('layouts.account.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
 public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Update name and email
    $user->fill($request->only(['name', 'email']));

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    if ($request->filled('current_password') || $request->filled('new_password')) {
    $request->validate([
        'current_password' => ['required', 'current_password'],
        'new_password' => ['required', 'confirmed', 'min:8'],
    ], [
        'current_password.current_password' => 'The current password is incorrect.',
    ]);
}


    // Validasi dan update password jika ada input
    if ($request->filled('current_password') || $request->filled('new_password')) {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->password = bcrypt($request->new_password);
    }

    $user->save();

    return Redirect::route('profile.edit')->with('success', 'Profile updated successfully.');

}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
