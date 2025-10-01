<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'location',
        'location_type',
        'photo_path',
        'photos',
        'status',
        'priority',
        'response_notes',
        'assigned_to',
        'responded_at',
        'is_user_satisfied',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'is_user_satisfied' => 'boolean',
        'photos' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
