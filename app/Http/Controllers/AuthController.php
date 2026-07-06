<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PendingRegistration;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function checkEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        $pending = PendingRegistration::where('email', $validated['email'])->first();

        if (!$pending) {
            return response()->json([
                'success' => false,
                'message' => 'Email ini belum didaftarkan oleh Admin. Silakan hubungi Admin untuk mendaftar.'
            ], 422);
        }

        if ($pending->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Email ini sudah digunakan untuk mendaftar sebelumnya.'
            ], 422);
        }

        // Cek juga apakah sudah ada di users
        $userExists = User::where('email', $validated['email'])->exists();
        if ($userExists) {
            return response()->json([
                'success' => false,
                'message' => 'Email ini sudah terdaftar sebagai pengguna aktif.'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Email valid, silakan lanjutkan pendaftaran.'
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check if email is in pending registrations
        $pending = PendingRegistration::where('email', $validated['email'])->first();

        if (!$pending) {
            return back()->withErrors([
                'email' => 'Email ini belum didaftarkan oleh Admin. Silakan hubungi Admin untuk mendaftar.',
            ])->onlyInput('name', 'email');
        }

        if ($pending->status !== 'pending') {
            return back()->withErrors([
                'email' => 'Email ini sudah digunakan untuk mendaftar sebelumnya.',
            ])->onlyInput('name', 'email');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin', // default role
        ]);

        // Update pending registration status
        $pending->update(['status' => 'registered']);

        // Do not auto-login as per user request
        // Auth::login($user);

        return redirect()->route('login')->with('success', 'Akun Anda telah berhasil dibuat. Mohon lakukan login menggunakan kredensial yang telah didaftarkan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
