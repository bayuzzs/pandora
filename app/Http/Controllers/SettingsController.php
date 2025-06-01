<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
  /**
   * Show the application settings page.
   */
  public function index()
  {
    return view('settings.index', [
      'user' => Auth::user(),
    ]);
  }

  /**
   * Update the user's notification settings.
   */
  public function updateNotifications(Request $request)
  {
    $validated = $request->validate([
      'email_notifications' => ['nullable', 'boolean'],
      'browser_notifications' => ['nullable', 'boolean'],
    ]);

    $user = Auth::user();
    // Update the notification settings
    // Assuming there's a settings relationship or columns on the user model
    // You'll need to adjust this based on your actual data structure

    // Example: if using a settings column as JSON
    $settings = $user->settings ?? [];
    $settings['notifications'] = [
      'email' => $request->boolean('email_notifications'),
      'browser' => $request->boolean('browser_notifications'),
    ];
    $user->settings = $settings;
    $user->save();

    return redirect()->route('settings')->with('status', 'notifications-updated');
  }

  /**
   * Update the user's application preferences.
   */
  public function updatePreferences(Request $request)
  {
    $validated = $request->validate([
      'theme' => ['required', 'string', 'in:light,dark,system'],
      'language' => ['required', 'string', 'in:en,id'],
    ]);

    $user = Auth::user();
    // Update the preferences
    // Similar to above, adjust based on your actual data structure

    $settings = $user->settings ?? [];
    $settings['preferences'] = [
      'theme' => $validated['theme'],
      'language' => $validated['language'],
    ];
    $user->settings = $settings;
    $user->save();

    return redirect()->route('settings')->with('status', 'preferences-updated');
  }
}