<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trip_id',
        'participants',
        'total_price',
        'status',
        'order_id',
        'confirmed_at',
        'preferred_date',
        'phone',
        'special_request',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'preferred_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function paymentTransaction()
    {
        return $this->hasOne(PaymentTransaction::class, 'reference_id', 'order_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
