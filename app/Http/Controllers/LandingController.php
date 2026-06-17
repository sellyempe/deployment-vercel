<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Review;
use App\Models\User;

class LandingController extends Controller
{
    public function index()
    {
        // Menghitung total user dengan role 'user'
        $totalTravelers = User::where('role', 'user')->count();
        $totalDestinations = Destination::count();
        $averageRating = Review::avg('rating') ?? 0;

        return view('landing', [
            'totalTravelers' => $totalTravelers,
            'totalDestinations' => $totalDestinations,
            'averageRating' => number_format($averageRating, 1),
        ]);
    }
}
