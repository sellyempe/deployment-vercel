<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    // GET /api/settings - Get all settings
    public function index()
    {
        $settings = CompanySetting::all();

        return response()->json($settings, 200);
    }

    // GET /api/settings/by-key/{key}
    public function getByKey($key)
    {
        $setting = CompanySetting::where(
            'key',
            $key
        )->first();

        if (! $setting) {
            return response()->json([
                'message' => 'Setting not found',
            ], 404);
        }

        return response()->json(
            $setting,
            200
        );
    }

    // GET /api/settings/by-category/{category}
    public function getByCategory($category)
    {
        $settings = CompanySetting::where(
            'category',
            $category
        )->get();

        return response()->json(
            $settings,
            200
        );
    }

    // POST /api/settings
    public function store(Request $request)
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'key' => 'required|string|unique:company_settings',
            'value' => 'required|string',
            'type' => 'required|in:string,number,text,boolean,json',
            'label' => 'nullable|string',
            'description' => 'nullable|string',
            'category' => 'nullable|in:general,contact,payment,email,social,other',
        ]);

        $setting = CompanySetting::create(
            $validated
        );

        return response()->json(
            $setting,
            201
        );
    }

    // PUT /api/settings/{id}
    public function update(
        Request $request,
        $id
    ) {
        $user = Auth::user();

        if (! $user || $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $setting = CompanySetting::findOrFail(
            $id
        );

        $validated = $request->validate([
            'value' => 'required|string',
            'type' => 'required|in:string,number,text,boolean,json',
            'label' => 'nullable|string',
            'description' => 'nullable|string',
            'category' => 'nullable|in:general,contact,payment,email,social,other',
        ]);

        $setting->update(
            $validated
        );

        return response()->json(
            $setting,
            200
        );
    }

    // DELETE /api/settings/{id}
    public function destroy($id)
    {
        $user = Auth::user();

        if (! $user || $user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $setting = CompanySetting::findOrFail(
            $id
        );

        $setting->delete();

        return response()->json([
            'message' => 'Setting deleted',
        ], 200);
    }
}
