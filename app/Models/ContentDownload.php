<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'user_id',
        'ip_address',
        'user_agent'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for recent downloads
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Get most downloaded content
    public static function getMostDownloaded($limit = 10)
    {
        return static::select('content_id')
            ->selectRaw('COUNT(*) as download_count')
            ->with('content')
            ->groupBy('content_id')
            ->orderByDesc('download_count')
            ->limit($limit)
            ->get()
            ->pluck('content')
            ->filter();
    }
}
