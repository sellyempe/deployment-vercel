<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // GET /api/reviews - Get all approved reviews
    public function index()
    {
        $reviews = Review::approved()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews, 200);
    }

    // GET /api/reviews/{type}/{itemId}
    public function getByItem($type, $itemId)
    {
        $modelType =
            $type === 'destination'
            ? 'App\\Models\\Destination'
            : 'App\\Models\\Trip';

        $reviews = Review::where(
            'reviewable_type',
            $modelType
        )
            ->where(
                'reviewable_id',
                $itemId
            )
            ->approved()
            ->with('user')
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(
            $reviews,
            200
        );
    }

    // POST /api/reviews
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewable_type' => 'required|in:App\Models\Trip,App\Models\Destination',

            'reviewable_id' => 'required|integer',

            'rating' => 'required|integer|min:1|max:5',

            'comment' => 'nullable|string|max:1000',
        ]);

        $user =
            User::find(
                Auth::id()
            );

        if (! $user) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        // Check if already reviewed
        $exists = Review::where(
            'user_id',
            $user->id
        )
            ->where(
                'reviewable_type',
                $validated['reviewable_type']
            )
            ->where(
                'reviewable_id',
                $validated['reviewable_id']
            )
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Anda sudah memberikan ulasan untuk item ini.',
            ], 409);
        }

        $review = Review::create([
            'user_id' => $user->id,

            'reviewable_type' => $validated['reviewable_type'],

            'reviewable_id' => $validated['reviewable_id'],

            'rating' => $validated['rating'],

            'comment' => $validated['comment'],

            'status' => 'approved',
        ]);

        return response()->json(
            $review,
            201
        );
    }

    // PUT /api/reviews/{id}
    public function update(
        Request $request,
        $id
    ) {

        $review =
            Review::findOrFail(
                $id
            );

        // hanya pemilik review
        if (
            Auth::id()
            !==
            $review->user_id
        ) {
            abort(
                403,
                'Unauthorized'
            );
        }

        $validated =
            $request->validate([
                'rating' => 'sometimes|integer|min:1|max:5',

                'comment' => 'sometimes|nullable|string|max:1000',

                'status' => 'sometimes|in:pending,approved,rejected',
            ]);

        $review->update(
            $validated
        );

        return response()->json(
            $review,
            200
        );
    }

    // DELETE /api/reviews/{id}
    public function destroy($id)
    {
        $review =
            Review::findOrFail(
                $id
            );

        // hanya pemilik review
        if (
            Auth::id()
            !==
            $review->user_id
        ) {
            abort(
                403,
                'Unauthorized'
            );
        }

        $review->delete();

        return response()->json([
            'message' => 'Review deleted',
        ], 200);
    }
}
