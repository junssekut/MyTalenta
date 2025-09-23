<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShuttleBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shuttle_route_id',
        'travel_date',
        'type',
        'notes',
        'status',
        'booking_deadline',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'booking_deadline' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shuttleRoute(): BelongsTo
    {
        return $this->belongsTo(ShuttleRoute::class);
    }
}
