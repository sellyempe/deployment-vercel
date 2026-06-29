<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'token.required' => 'Token reset kata sandi wajib disertakan.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal harus terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Let the User model's 'password' => 'hashed' cast handle hashing automatically
                $user->password = $password;
                $user->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diperbarui! Silakan masuk.');
        }

        $errorMsg = 'Gagal mereset kata sandi.';
        if ($status === Password::INVALID_TOKEN) {
            $errorMsg = 'Tautan reset kata sandi tidak valid atau sudah kedaluwarsa.';
        } elseif ($status === Password::INVALID_USER) {
            $errorMsg = 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.';
        } else {
            $errorMsg = 'Kata sandi baru harus minimal 8 karakter dan sesuai dengan konfirmasi.';
        }

        return back()->withErrors(['email' => $errorMsg]);
    }
}