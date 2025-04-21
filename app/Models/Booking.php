<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sport_id',
        'court_id',
        'slot_id',
        'is_member_booking',
        'is_group_game',
        'game_id',
        'membership_id',
        'booking_date',
        'number_of_players',
        'status',
        'payment_id',
        'refund_id',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'is_member_booking' => 'boolean',
        'is_group_game' => 'boolean',
        'number_of_players' => 'integer',
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

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function payment()
    {
        return $this->belongsTo(Transaction::class, 'payment_id');
    }

    public function refund()
    {
        return $this->belongsTo(Refund::class);
    }
}
