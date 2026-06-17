<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DestinationController extends Controller
{
    // GET /destination/{id}
    public function show(int $id)
    {
        $destination = Destination::with('images')->findOrFail($id);
        $destination->image = format_image_url($destination->image);

        $destination->images->transform(function ($img) {
            $img->path = format_image_url($img->path);
            return $img;
        });

        $hasReviewed = false;

        $user = Auth::user();

        if ($user) {
            $hasReviewed = Review::where(
                'user_id',
                $user->id
            )
                ->where(
                    'reviewable_type',
                    'App\Models\Destination'
                )
                ->where(
                    'reviewable_id',
                    $id
                )
                ->exists();
        }

        return view(
            'destination.detail',
            compact(
                'destination',
                'hasReviewed'
            )
        );
    }

    // GET /api/destinations
    public function index()
    {
        $destinations = Destination::with('images')->where('status', 'active')->get();

        $destinations->transform(function ($destination) {
            $destination->image = format_image_url($destination->image);
            $destination->images->transform(function ($img) {
                $img->path = format_image_url($img->path);
                return $img;
            });

            return $destination;
        });

        return response()->json(
            $destinations->values(),
            200
        );
    }

    // GET /api/destinations/{id}
    public function getDetail(int $id)
    {
        $destination =
            Destination::with('images')->findOrFail($id);

        $destination->image = format_image_url($destination->image);
        $destination->images->transform(function ($img) {
            $img->path = format_image_url($img->path);
            return $img;
        });

        return response()->json(
            $destination,
            200
        );
    }

    // POST /api/destinations
    public function store(
        Request $request
    ) {
        $validated =
            $request->validate([
                'name' => 'required|string|max:255',

                'description' => 'required|string',

                'interesting_fact' => 'required|string',

                'category' => 'required|string',

                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                
                'images' => 'nullable|array',
                
                'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

                'location' => 'required|string',
            ]);

        // SIMPAN FOTO UTAMA
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
        }

        $destination =
            Destination::create(
                $validated
            );

        // SIMPAN MULTIPLE IMAGES
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');
                $destination->images()->create(['path' => $path]);
            }
        } else if (isset($validated['image']) && $validated['image']) {
            $destination->images()->create([
                'path' => $validated['image'],
                'is_primary' => true
            ]);
        }

        return response()->json(
            $destination->load('images'),
            201
        );
    }

    // PUT /api/destinations/{id}
    public function update(
        Request $request,
        int $id
    ) {
        $destination =
            Destination::findOrFail(
                $id
            );

        $validated =
            $request->validate([
                'name' => 'sometimes|required|string|max:255',

                'description' => 'sometimes|required|string',

                'interesting_fact' => 'sometimes|required|string',

                'category' => 'sometimes|required|string',

                'image' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

                'images' => 'nullable|array',
                
                'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

                'location' => 'sometimes|required|string',
            ]);

        // UPDATE FOTO UTAMA
        if ($request->hasFile('image')) {
            // hapus foto lama
            if ($destination->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($destination->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($destination->image);
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
        }

        $destination->update(
            $validated
        );

        // UPDATE MULTIPLE IMAGES (ADD NEW ONES)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');
                $destination->images()->create(['path' => $path]);
            }
        }

        return response()->json(
            $destination->load('images'),
            200
        );
    }

    // DELETE /api/destinations/{id}
    public function destroy(
        int $id
    ) {
        $destination =
            Destination::findOrFail(
                $id
            );

        $destination->delete();

        return response()->json([
            'message' => 'Destination deleted',
        ], 200);
    }
}
