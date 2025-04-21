<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'created_by',
        'sport_id',
        'group_id',
        'game_date',
        'payment_id',
        'status',
    ];

    protected $casts = [
        'game_date' => 'datetime',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function payment()
    {
        return $this->belongsTo(Transaction::class, 'payment_id');
    }

    public function participants()
    {
        return $this->hasMany(GameParticipant::class, 'game_id');
    }
}
