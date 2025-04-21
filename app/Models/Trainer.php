<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = [
        'admin_user_id',
        'name',
        'photo',
        'description',
        'sports',
        'is_kid_trainer',
        'is_adult_trainer',
        'status',
    ];

    protected $casts = [
        'sports' => 'array',
        'is_kid_trainer' => 'boolean',
        'is_adult_trainer' => 'boolean',
    ];

    // Relationships
    public function trainerBookings()
    {
        return $this->hasMany(TrainerBooking::class);
    }

    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }
}
