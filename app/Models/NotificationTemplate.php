<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    protected $fillable = [
        'type',
        'title',
        'template',
        'variables',
        'via',
        'status',
    ];

    protected $casts = [
        'variables' => 'array',
    ];
}
