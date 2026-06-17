<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // Jika admin
            if (
                $user &&
                $user->role === 'admin'
            ) {

                return redirect()
                    ->route('admin.dashboard')
                    ->with(
                        'success',
                        'Selamat datang Admin'
                    )
                    ->with(
                        'success_title',
                        'Login Berhasil'
                    )
                    ->with(
                        'success_type',
                        'login'
                    );
            }

            // Jika user biasa
            return redirect('/')
                ->with(
                    'success',
                    'Selamat datang kembali, '.
                    $user->name
                )
                ->with(
                    'success_title',
                    'Login Berhasil'
                )
                ->with(
                    'success_type',
                    'login'
                );
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }
}
