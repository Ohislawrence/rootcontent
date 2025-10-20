<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'plan_id', 'starts_at', 'ends_at',
        'is_active', 'free_access_started_at'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'free_access_started_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function hasFreeAccessExpired()
    {
        if (!$this->free_access_started_at) {
            return false;
        }

        return $this->free_access_started_at->addHour()->isPast();
    }

    public function getRemainingFreeTrialTime()
    {
        if (!$this->free_access_started_at) {
            return null; // This is a paid subscription
        }

        $expiresAt = $this->free_access_started_at->addHour();
        return now()->diff($expiresAt);
    }

    public function getRemainingFreeTrialMinutes()
    {
        if (!$this->free_access_started_at) {
            return null;
        }

        $expiresAt = $this->free_access_started_at->addHour();
        return now()->diffInMinutes($expiresAt, false);
    }
}
