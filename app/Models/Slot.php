<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = [
        'sport_id',
        'court_id',
        'slot_date',
        'slot_time',
        'slot_end_time',
        'is_member_slot',
        'max_players',
        'available_slots',
        'is_peak_hour',
        'status',
    ];

    protected $casts = [
        'is_member_slot' => 'boolean',
        'is_peak_hour' => 'boolean',
        'status' => 'string',
        'slot_date' => 'date',
    ];

    // Relationships
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
