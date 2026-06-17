<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'description',
        'interesting_fact',
        'category',
        'category_id',
        'image',
        'location',
        'status',
    ];

    public function categoryRelation()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function wishlists()
    {
        return $this->morphMany(Wishlist::class, 'wishlistable');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function approvedReviews()
    {
        return $this->reviews()->approved();
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
