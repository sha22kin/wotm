<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'notice_number',
        'title_en',
        'title_bn',
        'description_en',
        'description_bn',
        'notice_date',
        'file_path',
        'file_type',
        'file_size',
        'is_pinned',
        'is_active',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_active' => 'boolean',
        'notice_date' => 'date',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->orderByRaw('COALESCE(notice_date, DATE(created_at)) DESC')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        $title = $locale === 'en' ? ($this->title_en ?: $this->title_bn) : ($this->title_bn ?: $this->title_en);
        return $title ?: ($this->title_en ?: ($this->title_bn ?: ''));
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        $desc = $locale === 'en' ? ($this->description_en ?: $this->description_bn) : ($this->description_bn ?: $this->description_en);
        return !empty($desc) ? $desc : null;
    }

    /**
     * Get reliable URL for notice attachment file
     */
    public function getFileUrlAttribute(): ?string
    {
        if (empty($this->file_path)) {
            return null;
        }

        if (str_starts_with($this->file_path, 'http://') || str_starts_with($this->file_path, 'https://')) {
            return $this->file_path;
        }

        $cleanPath = ltrim($this->file_path, '/');

        if (file_exists(public_path($cleanPath))) {
            return asset($cleanPath);
        }

        if (file_exists(public_path('storage/' . $cleanPath))) {
            return asset('storage/' . $cleanPath);
        }

        $storageSub = preg_replace('#^storage/#', '', $cleanPath);
        if (file_exists(storage_path('app/public/' . $storageSub))) {
            return asset(str_starts_with($cleanPath, 'storage/') ? $cleanPath : 'storage/' . $cleanPath);
        }

        return asset($cleanPath);
    }
}
