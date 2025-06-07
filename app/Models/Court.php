<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    protected $fillable = [
        'sport_id',
        'court_name',
        'court_type',
        'status',
        'images',
        'description',
    ];

    protected $casts = [
        'status' => 'string',
        'images' => 'array',
    ];

    // Relationships
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
