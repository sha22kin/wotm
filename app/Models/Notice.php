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
            ->orderBy('is_pinned', 'desc')
            ->orderBy('notice_date', 'desc');
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->title_en ?: $this->title_bn) : ($this->title_bn ?: $this->title_en);
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->description_en ?: $this->description_bn) : ($this->description_bn ?: $this->description_en);
    }
}
