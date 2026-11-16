<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login_id' => ['required', 'email'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:unit,admin'],
            'unit' => ['nullable', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $user = User::where('email', $request->login_id)->first();

        // Periksa apakah akun terdaftar.
        if (!$user || !Auth::validate([
            'email' => $request->login_id,
            'password' => $request->password,
        ])) {
            return back()
                ->withErrors([
                    'login_id' => 'Email atau password tidak sesuai.',
                ])
                ->withInput($request->only(
                    'login_id',
                    'role',
                    'unit'
                ));
        }

        // Role akun harus sesuai dengan workspace yang dipilih.
        if ($user->role !== $request->role) {
            return back()
                ->withErrors([
                    'login_id' => 'Akun tidak memiliki akses ke workspace tersebut.',
                ])
                ->withInput($request->only(
                    'login_id',
                    'role',
                    'unit'
                ));
        }

        // Pastikan akun Unit memilih unit yang sesuai.
        if ($user->role === 'unit') {
            $namaUnit = trim(preg_replace(
                '/^Unit\s+/i',
                '',
                (string) $request->unit
            ));

            if (
                !$user->unit ||
                strcasecmp($namaUnit, $user->unit->nama_unit) !== 0
            ) {
                return back()
                    ->withErrors([
                        'login_id' => 'Unit kerja tidak sesuai dengan akun.',
                    ])
                    ->withInput($request->only(
                        'login_id',
                        'role',
                        'unit'
                    ));
            }
        }

        // Buat sesi login Laravel.
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

      // Arahkan pengguna berdasarkan role akun.
if ($user->role === 'admin') {
    return redirect()->route('dashboardAdmin');
}

if ($user->role === 'unit') {
    return redirect()->route('dashboardUnit');
}

// Jika role tidak dikenali.
Auth::logout();

return back()
    ->withErrors([
        'login_id' => 'Role akun tidak dikenali.',
    ])
    ->withInput($request->only('login_id', 'role', 'unit'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}