<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title_en',
        'title_bn',
        'subtitle_en',
        'subtitle_bn',
        'content_en',
        'content_bn',
        'featured_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'canonical_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->title_en ?: $this->title_bn) : ($this->title_bn ?: $this->title_en);
    }

    public function getSubtitleAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->subtitle_en ?: $this->subtitle_bn) : ($this->subtitle_bn ?: $this->subtitle_en);
    }

    public function getContentAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->content_en ?: $this->content_bn) : ($this->content_bn ?: $this->content_en);
    }
}
