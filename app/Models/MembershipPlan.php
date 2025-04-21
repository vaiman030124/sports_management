<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    protected $fillable = [
        'title',
        'type',
        'price',
        'sessions',
        'sports_allowed',
        'duration_days',
        'trainer_id',
    ];

    protected $casts = [
        'sports_allowed' => 'array',
    ];

    // Relationships
    public function memberships()
    {
        return $this->hasMany(Membership::class, 'plan_id');
    }

    public function trainerBookings()
    {
        return $this->hasMany(TrainerBooking::class, 'plan_id');
    }

    public function trainer()
    {
        return $this->belongsTo(AdminUser::class, 'trainer_id');
    }
}
