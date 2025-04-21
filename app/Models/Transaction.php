<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'booking_id',
        'trainer_booking_id',
        'membership_id',
        'user_id',
        'amount',
        'payment_mode',
        'payment_reference',
        'status',
        'invoice_file',
        'transaction_date',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function trainerBooking()
    {
        return $this->belongsTo(TrainerBooking::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
