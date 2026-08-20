<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * One notification, as the app's सूचना tab shows it.
 */
class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'thumbnail',
        'link',
        'published_at',
        'status',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => 'boolean',
    ];

    /** Switched on, and not dated into the future. */
    public function scopePublished($query)
    {
        return $query->where('status', 1)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /** Newest first, on the date the notice was sent rather than saved. */
    public function scopeLatestFirst($query)
    {
        return $query->orderByRaw('COALESCE(published_at, created_at) DESC');
    }

    /**
     * The badge on the tab counts only the last 24 hours — a notice stops
     * being news the day after it goes out, and a badge that never clears
     * stops meaning anything.
     */
    public function scopeRecent($query)
    {
        return $query->whereRaw('COALESCE(published_at, created_at) >= ?', [now()->subDay()]);
    }

    /** The moment to show against the notice. */
    public function getSentAtAttribute()
    {
        return $this->published_at ?: $this->created_at;
    }
}
