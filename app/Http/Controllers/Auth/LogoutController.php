<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $user = Auth::user();
        $role = $user ? $user->role : 'user';
        $source = $request->input('logout_source');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($source === 'admin_dashboard') {
            $title = 'Admin Logout';
            $message = 'administrator telah berhasil keluar dari dashboard admin';
        } else {
            $title = 'Logout Berhasil';
            $message = ($role === 'admin')
                ? 'Anda telah berhasil keluar dari sistem manajemen.'
                : 'Anda telah berhasil keluar dari akun traveler.';
        }

        return redirect('/')
            ->with('success', $message)
            ->with('success_title', $title)
            ->with('success_type', 'logout');
    }
    }