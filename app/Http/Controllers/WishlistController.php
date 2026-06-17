<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // GET /api/wishlists - Get user's wishlists
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $wishlists = Wishlist::where('user_id', $user->id)
            ->with('wishlistable')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($wishlists, 200);
    }

    // POST /api/wishlists - Add to wishlist
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wishlistable_type' => 'required|string',
            'wishlistable_id' => 'required|integer',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $modelType = $this->resolveModelType($validated['wishlistable_type']);

        // Check if already exists
        $exists = Wishlist::where('user_id', $user->id)
            ->where('wishlistable_type', $modelType)
            ->where('wishlistable_id', $validated['wishlistable_id'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already in wishlist'], 200);
        }

        $wishlist = Wishlist::create([
            'user_id' => $user->id,
            'wishlistable_type' => $modelType,
            'wishlistable_id' => $validated['wishlistable_id'],
        ]);

        return response()->json($wishlist, 201);
    }

    // DELETE /api/wishlists/{id}
    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);

        if (Auth::id() !== $wishlist->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $wishlist->delete();

        return response()->json(['message' => 'Removed from wishlist'], 200);
    }

    // DELETE /api/wishlists/item/{type}/{itemId}
    public function destroyByItem($type, $itemId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $modelType = $this->resolveModelType($type);

        Wishlist::where('user_id', $user->id)
            ->where('wishlistable_type', $modelType)
            ->where('wishlistable_id', $itemId)
            ->delete();

        return response()->json(['message' => 'Removed from wishlist'], 200);
    }

    // GET /api/wishlists/check/{type}/{itemId}
    public function check($type, $itemId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['in_wishlist' => false], 200);
        }

        $modelType = $this->resolveModelType($type);

        $exists = Wishlist::where('user_id', $user->id)
            ->where('wishlistable_type', $modelType)
            ->where('wishlistable_id', $itemId)
            ->exists();

        return response()->json(['in_wishlist' => $exists], 200);
    }

    private function resolveModelType($type)
    {
        if ($type === 'trip') {
            return 'App\Models\Trip';
        }
        if ($type === 'destination') {
            return 'App\Models\Destination';
        }
        return str_replace('.', '\\', $type);
    }
}
