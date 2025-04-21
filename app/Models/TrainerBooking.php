<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerBooking extends Model
{
    protected $fillable = [
        'user_id',
        'trainer_id',
        'membership_id',
        'booking_date',
        'booking_time',
        'booking_end_time',
        'status',
        'payment_id',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'string',
        'booking_end_time' => 'string',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    public function payment()
    {
        return $this->belongsTo(Transaction::class, 'payment_id');
    }
}
