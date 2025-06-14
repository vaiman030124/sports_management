<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'created_by',
        'sport_id',
        'court_id',
        'slot_id',
        'group_id',
        'payment_id',
        'status',
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

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function participants()
    {
        return $this->hasMany(GameParticipant::class, 'game_id');
    }
}
