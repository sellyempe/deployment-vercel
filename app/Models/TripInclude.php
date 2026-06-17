<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TripInclude extends Model
{
    protected $fillable = [
        'trip_id',
        'item_name',
        'category',
        'category_id',
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function categoryRelation()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
