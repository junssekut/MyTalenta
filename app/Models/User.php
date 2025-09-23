<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'student_id',
        'card_id',
        'role_id',
        'batch_id',
        'phone',
        'address',
        'gender',
        'date_of_birth',
        'emergency_contact_name',
        'emergency_contact_phone',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // Relationships
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function shuttleBookings(): HasMany
    {
        return $this->hasMany(ShuttleBooking::class);
    }

    public function facilityBookings(): HasMany
    {
        return $this->hasMany(FacilityBooking::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function violationRecords(): HasMany
    {
        return $this->hasMany(ViolationRecord::class);
    }

    public function roomPics(): HasMany
    {
        return $this->hasMany(RoomPic::class);
    }

    // Helper methods
    public function hasRole(string $role): bool
    {
        return $this->role?->name === $role;
    }

    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    public function isComti(): bool
    {
        return $this->hasRole('komti') || $this->hasRole('wakomti');
    }

    public function isPIC(): bool
    {
        return $this->hasRole('pic_ppti') || $this->hasRole('pic_ppbp') || $this->hasRole('pic_shuttle');
    }

    public function isCoreTeam(): bool
    {
        return $this->hasRole('core_team') || $this->hasRole('admin_core_team');
    }
}
