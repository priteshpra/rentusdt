<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login'); // resources/views/admin/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        // Attempt with admin guard and ensure is_admin = 1
        if (Auth::guard('admin')->attempt(
            array_merge($credentials, ['is_admin' => 1]),
            $request->filled('remember')
        )) {
            // dd($credentials);
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // failed
        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records or you are not an admin.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
