<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripItinerary extends Model
{
    protected $fillable = [
        'trip_id',
        'day_number',
        'title',
        'description',
        'activities',
    ];

    protected $casts = [
        'activities' => 'array',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
