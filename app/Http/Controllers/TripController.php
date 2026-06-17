<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Trip;
use App\Models\TripDate;
use App\Models\TripExclude;
use App\Models\TripInclude;
use App\Models\TripItinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TripController extends Controller
{
    // DETAIL TRIP
    public function detail($id)
    {
        $trip = Trip::with([
            'itineraries',
            'includes',
            'excludes',
            'tripDates',
            'images',
        ])->findOrFail($id);

        $canReview = false;
        $user = Auth::user();

        if ($user) {

            $hasCompletedBooking = Booking::where(
                'user_id',
                $user->id
            )
                ->where('trip_id', $id)
                ->where('status', 'completed')
                ->exists();

            $hasReviewed = Review::where(
                'user_id',
                $user->id
            )
                ->where(
                    'reviewable_type',
                    'App\Models\Trip'
                )
                ->where(
                    'reviewable_id',
                    $id
                )
                ->exists();

            $canReview =
                $hasCompletedBooking
                &&
                ! $hasReviewed;
        }

        return view(
            'trip.detail',
            compact(
                'trip',
                'canReview'
            )
        );
    }

    // GET ALL TRIPS
    public function index()
    {
        $trips = Trip::with([
            'itineraries',
            'includes',
            'excludes',
            'tripDates',
            'images',
        ])
            ->where('status', 'active')
            ->get();

        $trips->transform(function ($trip) {
            $trip->image = format_image_url($trip->image);
            $trip->images->transform(function ($img) {
                $img->path = format_image_url($img->path);
                return $img;
            });

            return $trip;
        });

        return response()->json($trips->values());
    }

    // SHOW TRIP
    public function show($id)
    {
        $trip = Trip::with([
            'itineraries',
            'includes',
            'excludes',
            'tripDates',
            'images',
        ])->findOrFail($id);

        $trip->image = format_image_url($trip->image);
        $trip->images->transform(function ($img) {
            $img->path = format_image_url($img->path);
            return $img;
        });

        return response()->json($trip);
    }

    // STORE TRIP
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'overview' => 'required|string',
            'departure_city' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'meeting_point' => 'required|string|max:255',
            'meeting_address' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',

            // FOTO TRIP
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            // RELASI
            'itineraries' => 'nullable|array',
            'includes' => 'nullable|array',
            'excludes' => 'nullable|array',
            'trip_dates' => 'nullable|array',
            'trip_kuotas' => 'nullable|array',
        ]);

        // SIMPAN FOTO UTAMA
        if ($request->hasFile('image')) {

            $imagePath =
                $request->file('image')
                    ->store('images', 'public');

            $validated['image'] =
                $imagePath;
        }

        // SIMPAN TRIP
        $trip = Trip::create([
            'title' => $validated['title'],

            'description' => $validated['description'],

            'overview' => $validated['overview'],

            'departure_city' => $validated['departure_city'],

            'destination' => $validated['destination'],

            'meeting_point' => $validated['meeting_point'],

            'meeting_address' => $validated['meeting_address'],

            'price' => $validated['price'],

            'duration_days' => $validated['duration_days'],

            'status' => $validated['status'],

            'latitude' => $validated['latitude'] ?? null,

            'longitude' => $validated['longitude'] ?? null,

            'image' => $validated['image'] ?? null,
        ]);

        // SIMPAN MULTIPLE IMAGES
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');
                $trip->images()->create(['path' => $path]);
            }
        } else if ($validated['image']) {
            // Jika ada image utama tapi tidak ada gallery, masukkan image utama ke gallery sebagai primary
            $trip->images()->create([
                'path' => $validated['image'],
                'is_primary' => true
            ]);
        }

        // ITINERARY
        if ($request->has('itineraries')) {

            foreach (
                $request->itineraries as $itinerary
            ) {

                if (
                    ! empty(
                        $itinerary['title']
                    )
                ) {

                    TripItinerary::create([
                        'trip_id' => $trip->id,

                        'day_number' => $itinerary['day_number'],

                        'title' => $itinerary['title'],

                        'description' => $itinerary['description'],
                    ]);
                }
            }
        }

        // INCLUDE
        if ($request->has('includes')) {

            foreach (
                $request->includes as $include
            ) {

                if (
                    ! empty(
                        $include['item_name']
                    )
                ) {

                    TripInclude::create([
                        'trip_id' => $trip->id,

                        'item_name' => $include['item_name'],

                        'category' => $include['category']
                            ?? 'general',
                    ]);
                }
            }
        }

        // EXCLUDE
        if ($request->has('excludes')) {

            foreach (
                $request->excludes as $exclude
            ) {

                if (
                    ! empty(
                        $exclude['item_name']
                    )
                ) {

                    TripExclude::create([
                        'trip_id' => $trip->id,

                        'item_name' => $exclude['item_name'],

                        'category' => $exclude['category']
                            ?? 'general',
                    ]);
                }
            }
        }

        // TANGGAL TRIP
        if ($request->trip_dates) {

            foreach (
                $request->trip_dates as $index => $date
            ) {

                if (! empty($date)) {

                    TripDate::create([
                        'trip_id' => $trip->id,

                        'date' => $date,

                        'kuota' => $request->trip_kuotas[$index] ?? 0,
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.dashboard')
            ->with(
                'success',
                'Trip berhasil ditambahkan'
            );
    }

    // UPDATE TRIP
    public function update(
        Request $request,
        $id
    ) {

        $trip =
            Trip::findOrFail($id);

        $validated =
            $request->validate([
                'title' => 'required|string|max:255',

                'description' => 'required|string',

                'overview' => 'required|string',

                'departure_city' => 'required|string|max:255',

                'destination' => 'required|string|max:255',

                'meeting_point' => 'required|string|max:255',

                'meeting_address' => 'required|string|max:255',

                'price' => 'required|numeric',

                'duration_days' => 'required|integer|min:1',

                'status' => 'required|in:active,inactive',

                'latitude' => 'nullable|numeric',

                'longitude' => 'nullable|numeric',

                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

                'images' => 'nullable|array',

                'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            ]);

        // UPDATE FOTO
        if ($request->hasFile('image')) {

            // hapus foto lama
            if (
                $trip->image &&
                Storage::disk('public')
                    ->exists($trip->image)
            ) {

                Storage::disk('public')
                    ->delete($trip->image);
            }

            // upload baru
            $imagePath =
                $request->file('image')
                    ->store('images', 'public');

            $validated['image'] =
                $imagePath;
        }

        $trip->update(
            $validated
        );

        // UPDATE MULTIPLE IMAGES (ADD NEW ONES)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');
                $trip->images()->create(['path' => $path]);
            }
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Trip berhasil diperbarui'
            );
    }

    // DELETE TRIP
    public function destroy($id)
    {
        $trip =
            Trip::findOrFail($id);

        // hapus foto
        if (
            $trip->image &&
            Storage::disk('public')
                ->exists($trip->image)
        ) {

            Storage::disk('public')
                ->delete($trip->image);
        }

        $trip->delete();

        return response()->json(
            null,
            204
        );
    }
}
