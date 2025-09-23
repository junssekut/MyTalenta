<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShuttleRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'destination',
        'description',
        'departure_time',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'departure_time' => 'datetime:H:i',
        'capacity' => 'integer',
        'is_active' => 'boolean',
    ];

    public function shuttleBookings(): HasMany
    {
        return $this->hasMany(ShuttleBooking::class);
    }
}
