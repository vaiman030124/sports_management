<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = [
        'booking_id',
        'trainer_booking_id',
        'transaction_id',
        'reason',
        'amount',
        'refund_to',
        'status',
        'processed_by',
        'processed_at',
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

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(AdminUser::class, 'processed_by');
    }
}
