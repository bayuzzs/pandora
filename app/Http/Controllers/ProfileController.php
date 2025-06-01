<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
  /**
   * Show the form for editing the user's profile.
   */
  public function edit()
  {
    return view('profile.edit', [
      'user' => Auth::user(),
    ]);
  }

  /**
   * Update the user's profile information.
   */
  public function update(Request $request)
  {
    $validated = $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
    ]);

    $user = Auth::user();
    $user->fill($validated);
    $user->save();

    return redirect()->route('profile.edit')->with('status', 'profile-updated');
  }

  /**
   * Update the user's password.
   */
  public function updatePassword(Request $request)
  {
    $validated = $request->validate([
      'current_password' => ['required', 'current_password'],
      'password' => ['required', Password::defaults(), 'confirmed'],
    ]);

    $user = Auth::user();
    $user->password = Hash::make($validated['password']);
    $user->save();

    return redirect()->route('profile.edit')->with('status', 'password-updated');
  }
}