<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admin,username',
            'password' => 'required|min:6',
            'nama'     => 'required'
        ]);

        Admin::create($request->only('username', 'password', 'nama'));

        return redirect('/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $admin = Admin::where('username', $credentials['username'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Session::put('admin_id', $admin->id_user);
            Session::put('admin_nama', $admin->nama);

            return redirect('/dashboard'); // Sesuaikan rute dashboard
        }

        return back()->withErrors(['login' => 'Username atau password salah']);
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}

