<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'duration', 'months', 'price', 'description',
        'features', 'is_active', 'is_default'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'features' => 'array',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeTermly($query)
    {
        return $query->where('duration', 'termly');
    }

    public function scopeYearly($query)
    {
        return $query->where('duration', 'yearly');
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return '₦' . number_format($this->price, 2);
    }

    public function getFeaturesAttribute($value)
    {
        // If it's already an array, return it
        if (is_array($value)) {
            return $value;
        }
        
        // If it's a JSON string, decode it
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        // If it's null or anything else, return empty array
        return [];
    }

    public function setFeaturesAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['features'] = json_encode(array_values($value));
        } else {
            $this->attributes['features'] = json_encode([]);
        }
    }

    public function getDurationTextAttribute()
    {
        return ucfirst($this->duration);
    }

    public function getStatusBadgeAttribute()
    {
        if (!$this->is_active) {
            return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>';
        }

        if ($this->is_default) {
            return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active (Default)</span>';
        }

        return '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Active</span>';
    }

    // Check if plan can be deleted
    public function getCanDeleteAttribute()
    {
        return !$this->subscriptions()
            ->where('is_active', true)
            ->where('ends_at', '>', now())
            ->exists();
    }
}
