<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\Review;
use App\Models\Trip;
use App\Models\TripExclude;
use App\Models\TripInclude;
use App\Models\TripItinerary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ─── Helper ──────────────────────────────────────────────────────────────

    /**
     * Simpan file gambar ke storage dan kembalikan path-nya.
     * Jika ada gambar lama, hapus dulu.
     */
    private function handleImageUpload(Request $request, string $field, ?string $oldPath = null): ?string
    {
        if (! $request->hasFile($field)) {
            return $oldPath; // tidak ada upload baru, kembalikan path lama
        }

        // Hapus gambar lama jika ada
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        $file = $request->file($field);

        return $file->store('images/'.$field.'s', 'public');
    }

    // ======== TRIPS ========

    public function dashboard()
    {
        $trips = Trip::withCount('bookings')->latest()->get();
        $counts = [
            'trips' => Trip::count(),
            'destinations' => Destination::count(),
            'bookings' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('trips', 'counts'));
    }

    public function createTrip()
    {
        return view('admin.trips.create');
    }

    public function storeTrip(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'overview' => 'required|string',
            'departure_city' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'meeting_point' => 'required|string',
            'meeting_address' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:active,inactive',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'trip_dates' => 'required|array|min:1',
            'trip_dates.*' => 'required|date',
            'trip_kuotas' => 'required|array|min:1',
            'trip_kuotas.*' => 'required|integer|min:1',
        ]);

        // Create trip without image first
        $trip = Trip::create(array_merge($validated, ['image' => '']));

        // Handle Multiple Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('images/trips', 'public');
                $imageUrl = Storage::url($path);
                
                $trip->images()->create([
                    'path' => $imageUrl,
                    'is_primary' => $index === 0
                ]);

                // Set the first image as the main thumbnail
                if ($index === 0) {
                    $trip->update(['image' => $imageUrl]);
                }
            }
        }

        // Itineraries
        if ($request->has('itineraries')) {
            foreach ($request->itineraries as $itinerary) {
                if (empty($itinerary['title'])) {
                    continue;
                }
                TripItinerary::create([
                    'trip_id' => $trip->id,
                    'day_number' => $itinerary['day_number'],
                    'title' => $itinerary['title'],
                    'description' => $itinerary['description'] ?? '',
                    'activities' => [],
                ]);
            }
        }

        // Includes
        if ($request->has('includes')) {
            foreach ($request->includes as $include) {
                if (empty($include['item_name'])) {
                    continue;
                }
                TripInclude::create([
                    'trip_id' => $trip->id,
                    'item_name' => $include['item_name'],
                    'category' => $include['category'] ?? '',
                ]);
            }
        }

        // Excludes
        if ($request->has('excludes')) {
            foreach ($request->excludes as $exclude) {
                if (empty($exclude['item_name'])) {
                    continue;
                }
                TripExclude::create([
                    'trip_id' => $trip->id,
                    'item_name' => $exclude['item_name'],
                    'category' => $exclude['category'] ?? '',
                ]);
            }
        }

        // Trip Dates
        if ($request->has('trip_dates')) {
            foreach ($request->trip_dates as $index => $date) {
                if (empty($date)) {
                    continue;
                }
                $trip->tripDates()->create([
                    'date' => $date,
                    'kuota' => $request->trip_kuotas[$index] ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Trip "'.$trip->title.'" berhasil ditambahkan!');
    }

    public function editTrip($id)
    {
        $trip = Trip::with(['itineraries', 'includes', 'excludes', 'tripDates', 'images'])->findOrFail($id);

        return view('admin.trips.edit', compact('trip'));
    }

    public function updateTrip(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'overview' => 'required|string',
            'departure_city' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'meeting_point' => 'required|string',
            'meeting_address' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:active,inactive',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'trip_dates' => 'required|array|min:1',
            'trip_dates.*' => 'required|date',
            'trip_kuotas' => 'required|array|min:1',
            'trip_kuotas.*' => 'required|integer|min:1',
        ]);

        $trip->update($validated);

        // Multiple Images (Add new ones)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images/trips', 'public');
                $imageUrl = Storage::url($path);
                
                $trip->images()->create([
                    'path' => $imageUrl,
                    'is_primary' => false
                ]);

                // If trip has no image yet, set this one as main
                if (!$trip->image) {
                    $trip->update(['image' => $imageUrl]);
                }
            }
        }

        // Update Trip Dates
        $trip->tripDates()->delete();
        if ($request->has('trip_dates')) {
            foreach ($request->trip_dates as $index => $date) {
                if (empty($date)) {
                    continue;
                }
                $trip->tripDates()->create([
                    'date' => $date,
                    'kuota' => $request->trip_kuotas[$index] ?? 0,
                ]);
            }
        }

        // Update Itineraries
        $trip->itineraries()->delete();
        if ($request->has('itineraries')) {
            foreach ($request->itineraries as $itinerary) {
                if (empty($itinerary['title'])) {
                    continue;
                }
                TripItinerary::create([
                    'trip_id' => $trip->id,
                    'day_number' => $itinerary['day_number'],
                    'title' => $itinerary['title'],
                    'description' => $itinerary['description'] ?? '',
                    'activities' => [],
                ]);
            }
        }

        // Update Includes
        $trip->includes()->delete();
        if ($request->has('includes')) {
            foreach ($request->includes as $include) {
                if (empty($include['item_name'])) {
                    continue;
                }
                TripInclude::create([
                    'trip_id' => $trip->id,
                    'item_name' => $include['item_name'],
                    'category' => $include['category'] ?? '',
                ]);
            }
        }

        // Update Excludes
        $trip->excludes()->delete();
        if ($request->has('excludes')) {
            foreach ($request->excludes as $exclude) {
                if (empty($exclude['item_name'])) {
                    continue;
                }
                TripExclude::create([
                    'trip_id' => $trip->id,
                    'item_name' => $exclude['item_name'],
                    'category' => $exclude['category'] ?? '',
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Trip "'.$trip->title.'" berhasil diperbarui!');
    }

    public function destroyTrip($id)
    {
        $trip = Trip::findOrFail($id);

        // Hapus gambar dari storage
        if ($trip->image && str_contains($trip->image, '/storage/')) {
            $path = str_replace('/storage/', '', parse_url($trip->image, PHP_URL_PATH));
            Storage::disk('public')->delete($path);
        }

        $trip->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Trip berhasil dihapus.');
    }

    // ======== DESTINATIONS ========

    public function destinationsDashboard()
    {
        $destinations = Destination::latest()->get();

        return view('admin.destinations.dashboard', compact('destinations'));
    }

    public function createDestination()
    {
        return view('admin.destinations.create');
    }

    public function storeDestination(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'interesting_fact' => 'required|string',
            'category' => 'required|string',
            'location' => 'required|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:active,inactive',
        ]);

        $destination = Destination::create(array_merge($validated, ['image' => '']));

        // Handle Multiple Images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('images/destinations', 'public');
                $imageUrl = Storage::url($path);
                
                $destination->images()->create([
                    'path' => $imageUrl,
                    'is_primary' => $index === 0
                ]);

                if ($index === 0) {
                    $destination->update(['image' => $imageUrl]);
                }
            }
        }

        return redirect()->route('admin.destinations.dashboard')->with('success', 'Destinasi berhasil ditambahkan!');
    }

    public function editDestination($id)
    {
        $destination = Destination::with('images')->findOrFail($id);

        return view('admin.destinations.edit', compact('destination'));
    }

    public function updateDestination(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'interesting_fact' => 'required|string',
            'category' => 'required|string',
            'location' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:active,inactive',
        ]);

        $destination->update($validated);

        // Multiple Images (Add new ones)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images/destinations', 'public');
                $imageUrl = Storage::url($path);
                
                $destination->images()->create([
                    'path' => $imageUrl,
                    'is_primary' => false
                ]);

                if (!$destination->image) {
                    $destination->update(['image' => $imageUrl]);
                }
            }
        }

        return redirect()->route('admin.destinations.dashboard')->with('success', 'Destinasi berhasil diperbarui!');
    }

    public function destroyDestination($id)
    {
        $destination = Destination::findOrFail($id);

        if ($destination->image && str_contains($destination->image, '/storage/')) {
            $path = str_replace('/storage/', '', parse_url($destination->image, PHP_URL_PATH));
            Storage::disk('public')->delete($path);
        }

        $destination->delete();

        return redirect()->route('admin.destinations.dashboard')->with('success', 'Destinasi berhasil dihapus.');
    }

    // ======== REVIEWS ========

    public function reviewsDashboard()
    {
        $status = request('status', 'all');
        $allReviews = Review::with('user', 'reviewable')->latest()->get();
        $pendingReviews = $allReviews->where('status', 'pending');
        $approvedReviews = $allReviews->where('status', 'approved');
        $rejectedReviews = $allReviews->where('status', 'rejected');

        $reviews = match ($status) {
            'pending' => $pendingReviews,
            'approved' => $approvedReviews,
            'rejected' => $rejectedReviews,
            default => $allReviews,
        };

        return view('admin.reviews.dashboard', compact('reviews', 'allReviews', 'pendingReviews', 'approvedReviews', 'rejectedReviews'));
    }

    public function approveReview($id)
    {
        Review::findOrFail($id)->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Review disetujui.');
    }

    public function rejectReview($id)
    {
        Review::findOrFail($id)->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Review ditolak.');
    }

    // ======== BOOKINGS ========

    public function bookingsDashboard()
    {
        $status = request('status', 'all');
        $query = Booking::with(['user', 'trip'])->latest();
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        $bookings = $query->paginate(20)->withQueryString();
        $counts = Booking::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('admin.bookings.dashboard', compact('bookings', 'counts', 'status'));
    }

    public function exportBookings($status)
    {
        return \App\Exports\BookingExport::download($status);
    }

    public function completeBooking($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Hanya booking terkonfirmasi yang dapat diselesaikan.');
        }
        $booking->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Booking #'.$booking->order_id.' ditandai selesai.');
    }

    // ======== SETTINGS ========

    public function settings()
    {
        $settings = \App\Models\CompanySetting::all()->groupBy('category');

        return view('admin.settings.index', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $settings = $request->except(['_token', '_method']);

        foreach ($settings as $key => $value) {
            $setting = \App\Models\CompanySetting::where('key', $key)->first();
            if ($setting) {
                if ($setting->type === 'image' && $request->hasFile($key)) {
                    $oldPath = null;
                    if ($setting->value && str_contains($setting->value, '/storage/')) {
                        $oldPath = str_replace('/storage/', '', parse_url($setting->value, PHP_URL_PATH));
                    }
                    $path = $this->handleImageUpload($request, $key, $oldPath);
                    $setting->value = Storage::url($path);
                } else {
                    $setting->value = $value;
                }
                $setting->save();
            }
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function destroyImage($id)
    {
        $image = \App\Models\Image::findOrFail($id);

        // Ambil path file
        $path = str_replace('/storage/', '', parse_url($image->path, PHP_URL_PATH));
        
        // Hapus file fisik
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // Jika ini adalah image utama di model induk, kosongkan field image di model tersebut
        $parent = $image->imageable;
        if ($parent && $parent->image === $image->path) {
            $parent->update(['image' => '']);
            
            // Coba cari image lain untuk jadi utama
            $nextImage = $parent->images()->where('id', '!=', $id)->first();
            if ($nextImage) {
                $parent->update(['image' => $nextImage->path]);
                $nextImage->update(['is_primary' => true]);
            }
        }

        $image->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus dari galeri');
    }
}