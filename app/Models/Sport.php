<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    protected $fillable = [
        'sport_name',
        'venue_id',
        'court_count',
        'shared_with',
        'pricing_peak',
        'pricing_non_peak',
        'status',
    ];

    protected $casts = [
        'shared_with' => 'array',
        'status' => 'string',
    ];

    // Relationships
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function courts()
    {
        return $this->hasMany(Court::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
