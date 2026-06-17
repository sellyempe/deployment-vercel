<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users',

            'password' => 'required|min:6|confirmed',
        ]);

        // Simpan user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make(
                $validated['password']
            ),
            'role' => 'user',
        ]);

        // Trigger event Registered untuk mengirim email verifikasi
        event(new Registered($user));

        // Auto login
        Auth::login($user);

        // Redirect ke dashboard atau landing dengan pesan info verifikasi
        return redirect('/email/verify')
            ->with(
                'success',
                'Akun berhasil dibuat! Silakan cek email Anda untuk verifikasi.'
            );
    }
}
