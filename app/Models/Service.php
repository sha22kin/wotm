<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title_en',
        'title_bn',
        'slug',
        'category',
        'short_description_en',
        'short_description_bn',
        'description_en',
        'description_bn',
        'image',
        'icon',
        'beneficiaries_count',
        'districts_count',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->title_en ?: $this->title_bn) : ($this->title_bn ?: $this->title_en);
    }

    public function getShortDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->short_description_en ?: $this->short_description_bn) : ($this->short_description_bn ?: $this->short_description_en);
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->description_en ?: $this->description_bn) : ($this->description_bn ?: $this->description_en);
    }
}
