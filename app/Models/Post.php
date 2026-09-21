<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'category_id',
        'title_en',
        'title_bn',
        'slug',
        'excerpt_en',
        'excerpt_bn',
        'content_en',
        'content_bn',
        'featured_image',
        'author_name',
        'status',
        'is_featured',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->title_en ?: $this->title_bn) : ($this->title_bn ?: $this->title_en);
    }

    public function getExcerptAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->excerpt_en ?: $this->excerpt_bn) : ($this->excerpt_bn ?: $this->excerpt_en);
    }

    public function getContentAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->content_en ?: $this->content_bn) : ($this->content_bn ?: $this->content_en);
    }
}
