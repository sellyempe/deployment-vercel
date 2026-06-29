<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the user's profile
     */
    public function show()
    {
        $user = Auth::user();

        return view('profile', [
            'user' => $user,
        ]);
    }

    /**
     * Show the edit profile form
     */
    public function edit()
    {
        $user = Auth::user();

        return view('edit-profile', [
            'user' => $user,
        ]);
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|regex:/^[0-9]+$/|min:10|max:13',
            'gender' => 'nullable|in:male,female,other',
            'birth_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'phone.min' => 'Nomor telepon minimal harus terdiri dari 10 angka.',
            'phone.max' => 'Nomor telepon maksimal harus terdiri dari 13 angka.',
            'birth_date.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari hari ini.',
            'email.unique' => 'Email sudah terdaftar.',
            'photo.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->gender = $validated['gender'] ?? null;
        $user->birth_date = $validated['birth_date'] ?? null;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            // Store new photo
            $photo = $request->file('photo')->store('profiles', 'public');
            $user->photo = $photo;
        }

        // Save user
        $user->save();

        return redirect()
            ->route('profile')
            ->with('success', 'Profile berhasil diperbarui!')
            ->with('success_type', 'profile');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();


        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.current_password' => 'Password saat ini tidak cocok.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()
            ->route('profile')
            ->with('success', 'Password berhasil diperbarui!');
    }
}