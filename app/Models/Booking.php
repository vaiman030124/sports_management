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
        'venue_id',
        'group_id',
        'trainer_id',
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

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
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

    /**
     * Check if the court is already booked for the given slot, date, and sport or any sport sharing the court.
     *
     * @param int $courtId
     * @param int $slotId
     * @param string $bookingDate (Y-m-d)
     * @param int $sportId
     * @return bool
     */
    public static function isCourtBookedForSlot($courtId, $slotId, $bookingDate, $sportId)
    {
        $sport = Sport::find($sportId);
        if (!$sport) {
            return false;
        }

        // Get all sports sharing the court including current sport
        $sharedSportsNames = $sport->shared_with ?? [];
        $sharedSportsNames[] = $sport->sport_name;

        // Get sport IDs for all shared sports
        $sharedSportIds = Sport::whereIn('sport_name', $sharedSportsNames)->pluck('id')->toArray();

        // Check if any booking exists for the court, slot, date, and any of these sports with status pending or confirmed
        $conflictCount = self::where('court_id', $courtId)
            ->where('slot_id', $slotId)
            ->whereDate('booking_date', $bookingDate)
            ->whereIn('sport_id', $sharedSportIds)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        return $conflictCount > 0;
    }
}
