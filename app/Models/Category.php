<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_type',
        'category_name',
    ];

    const TYPE_DESTINATION = 1;

    const TYPE_TRIP_INCLUDE = 2;

    const TYPE_TRIP_EXCLUDE = 3;
}
