<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = [
        'venue_name',
        'location',
        'description',
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'status' => 'string',
    ];

    // Relationships
    public function sports()
    {
        return $this->hasMany(Sport::class);
    }
}
