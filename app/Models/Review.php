<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'sport_id',
        'venue_id',
        'trainer_id',
        'booking_id',
        'trainer_booking_id',
        'rating',
        'review_text',
        'status',
        'admin_response',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function trainerBooking()
    {
        return $this->belongsTo(TrainerBooking::class);
    }
}
