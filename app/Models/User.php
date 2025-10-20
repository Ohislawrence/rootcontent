<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'name', 'email', 'password', 'role_id', 'phone', 'school_name',
        'school_type', 'state', 'lga', 'is_active', 'last_login_at', 'registered_at'
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
            'last_login_at' => 'datetime',
            'registered_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            // Set registered_at to current time if not provided
            if (empty($user->registered_at)) {
                $user->registered_at = now();
            }

            // Set default role_id to subscriber (2) if not provided
            if (empty($user->role_id)) {
                $user->role_id = 2; // Subscriber role
            }

            // Set is_active to true by default
            if (is_null($user->is_active)) {
                $user->is_active = true;
            }
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isAdmin()
    {
        return $this->role_id === 1; // Assuming 1 is admin role
    }

    public function isSubscriber()
    {
        return $this->role_id === 2; // Assuming 2 is subscriber role
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->latest();
    }

    public function scopeSubscribers($query)
    {
        return $query->where('role_id', 2); // Assuming 2 is subscriber role
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function getSubscriptionStatusAttribute()
    {
        if (!$this->activeSubscription) {
            return 'No Active Subscription';
        }

        if ($this->activeSubscription->free_access_started_at) {
            return 'Free Trial';
        }

        return 'Paid Subscription';
    }

    public function getRemainingSubscriptionDaysAttribute()
    {
        if (!$this->activeSubscription) {
            return 0;
        }

        return now()->diffInDays($this->activeSubscription->ends_at, false);
    }

    public function hasActiveSubscription()
    {
        return $this->subscriptions()
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->exists();
    }

    public function hasActivePaidSubscription()
    {
        return $this->subscriptions()
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->whereNull('free_access_started_at') // This is a paid subscription
            ->exists();
    }

    public function hasActiveTrialSubscription()
    {
        return $this->subscriptions()
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->whereNotNull('free_access_started_at')
            ->exists();
    }

    public function hasUsedFreeTrial()
    {
        return $this->subscriptions()
            ->whereNotNull('free_access_started_at')
            ->exists();
    }

    public function currentSubscription()
    {
        return $this->subscriptions()
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->first();
    }
}
