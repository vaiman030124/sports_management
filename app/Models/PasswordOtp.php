<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PasswordOtp extends Model
{
    public $timestamps = false;

    protected $table = 'otp_password_resets';

    protected $fillable = [
        'email',
        'otp',
        'created_at',
        'expires_at',
        'verified_at',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    public function markExpired()
    {
        $this->status = 'expired';
        $this->save();
    }

    public function markVerified()
    {
        $this->status = 'verified';
        $this->verified_at = Carbon::now();
        $this->save();
    }
}
