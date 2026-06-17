<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $table = 'company_settings';

    protected $fillable = [
        'key',
        'value',
        'type',
        'label',
        'description',
        'category',
    ];
}
