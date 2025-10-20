<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'level', 'order'];

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    // Scopes for different levels
    public function scopePrimary($query)
    {
        return $query->where('level', 'primary');
    }

    public function scopeJuniorSecondary($query)
    {
        return $query->where('level', 'junior_secondary');
    }

    public function scopeSeniorSecondary($query)
    {
        return $query->where('level', 'senior_secondary');
    }
}
