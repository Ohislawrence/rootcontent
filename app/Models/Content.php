<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'file_path', 'file_type',
        'grade_level_id', 'subject_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function views()
    {
        return $this->hasMany(ContentView::class);
    }

    public function downloads()
    {
        return $this->hasMany(ContentDownload::class);
    }

    // Accessors for quick stats
    public function getViewsCountAttribute()
    {
        return $this->views()->count();
    }

    public function getDownloadsCountAttribute()
    {
        return $this->downloads()->count();
    }

    public function getRecentViewsCountAttribute()
    {
        return $this->views()->recent(7)->count();
    }

    public function getRecentDownloadsCountAttribute()
    {
        return $this->downloads()->recent(7)->count();
    }

    // Scope for popular content
    public function scopePopular($query)
    {
        return $query->withCount('views')
                    ->orderByDesc('views_count');
    }

    // Scope for most downloaded
    public function scopeMostDownloaded($query)
    {
        return $query->withCount('downloads')
                    ->orderByDesc('downloads_count');
    }

    // Scope for recent content
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
