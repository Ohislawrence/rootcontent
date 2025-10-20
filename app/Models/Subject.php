<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'grade_levels'];

    protected $casts = [
        'grade_levels' => 'array',
    ];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    // Scopes for different categories
    public function scopeCore($query)
    {
        return $query->where('category', 'core');
    }

    public function scopeArts($query)
    {
        return $query->where('category', 'arts');
    }

    public function scopeScience($query)
    {
        return $query->where('category', 'science');
    }

    public function scopeCommercial($query)
    {
        return $query->where('category', 'commercial');
    }

    public function scopeTechnical($query)
    {
        return $query->where('category', 'technical');
    }
}
