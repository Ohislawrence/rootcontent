<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentView extends Model
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

    // Scope for recent views
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Get popular content
    public static function getPopularContent($limit = 10)
    {
        return static::select('content_id')
            ->selectRaw('COUNT(*) as view_count')
            ->with('content')
            ->groupBy('content_id')
            ->orderByDesc('view_count')
            ->limit($limit)
            ->get()
            ->pluck('content')
            ->filter();
    }
}
