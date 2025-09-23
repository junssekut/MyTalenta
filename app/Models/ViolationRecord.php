<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ViolationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'violation_type',
        'description',
        'violation_date',
        'severity',
        'action_taken',
        'recorded_by',
        'is_resolved',
        'resolved_at',
    ];

    protected $casts = [
        'violation_date' => 'date',
        'is_resolved' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
